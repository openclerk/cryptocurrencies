<?php

namespace Cryptocurrency\Services;

use \Monolog\Logger;
use \Apis\Fetch;
use \Apis\FetchException;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\Currency;
use \Openclerk\Currencies\BlockCurrency;

abstract class AbstractNuExplorerService {

  function __construct(Currency $currency, $args) {
    $this->currency = $currency;

    // default parameters
    $args += array(
      "info_url" => false,
    );

    $this->url = $args["url"];
    $this->info_url = $args["info_url"];
  }

  /**
   *
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger, $is_received = false) {

    $code = $this->currency->getCode();

    if ($is_received) {
      $logger->info("We are looking for received balance.");
    }

    $url = sprintf($this->url, $address);
    $logger->info($url);

    try {
      $json = Fetch::jsonDecode(Fetch::get($url));
    } catch (\Apis\FetchHttpException $e) {
      throw new BalanceException($e->getContent(), $e);
    }
    if (!$json['exists']) {
      throw new BalanceException("Address does not exist");
    }

    if ($is_received) {
      if (!isset($json['totalInInt'])) {
        throw new BalanceException("Could not find received balance");
      }
      $balance = $json['totalInInt'];
    } else {
      if (!isset($json['totalBalanceInt'])) {
        throw new BalanceException("Could not find current balance");
      }
      $balance = $json['totalBalanceInt'];
    }

    return $balance;
  }

  function getBlockCount(Logger $logger) {
    if (!$this->info_url) {
      throw new BlockException("No known block URL for currency '" . $this->currency->getCode() . "'");
    }

    $url = $this->info_url;

    $logger->info($url);
    $json = Fetch::jsonDecode(Fetch::get($url));
    if (!isset($json['heightInt'])) {
      throw new BlockException("Could not find block height");
    }
    $value = $json['heightInt'];
    $logger->info("Block count: " . number_format($value));
    return $value;
  }

  /**
   * @return the Proof of Work difficulty
   */
  function getDifficulty(Logger $logger) {
    if (!$this->info_url) {
      throw new DifficultyException("No known difficulty URL for currency '" . $this->currency->getCode() . "'");
    }

    $url = $this->info_url;

    $logger->info($url);
    $json = Fetch::jsonDecode(Fetch::get($url));
    if (!isset($json['powInt'])) {
      throw new BlockException("Could not find block height");
    }
    $value = $json['powInt'];
    $logger->info("Difficulty: " . number_format($value));
    return $value;
  }

}
