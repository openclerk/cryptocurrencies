<?php

namespace Cryptocurrency\Services;

use \Monolog\Logger;
use \Apis\Fetch;
use \Apis\JSendException;
use \Apis\FetchException;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\Currency;
use \Openclerk\Currencies\BlockCurrency;

abstract class AbstractBlockrService {

  function __construct(Currency $currency, $args) {
    $this->currency = $currency;

    // default parameters
    $args += array(
      "confirmations" => 6,
      "block_url" => false,
      "difficulty_url" => false,
    );

    $this->url = $args["url"];
    $this->block_url = $args["block_url"];
    $this->difficulty_url = $args["difficulty_url"];
    $this->confirmations = $args["confirmations"];
  }

  /**
   *
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger, $is_received = false) {
    return $this->getBalanceWithConfirmations($address, $this->confirmations, $logger, $is_received);
  }

  function getBalanceWithConfirmations($address, $confirmations, Logger $logger, $is_received = false) {
    $url = sprintf($this->url, $address) . "?confirmations=" . $confirmations;

    $logger->info($url);
    $json = Fetch::jsonDecode(Fetch::get($url));

    if (isset($json['data']['is_valid']) && !$json['data']['is_valid']) {
      throw new BalanceException("Address is not valid");
    }

    try {
      $data = Fetch::checkJSend($json);
    } catch (JSendException $e) {
      throw new BalanceException($e->getMessage(), $e);
    }

    if ($is_received) {
      $logger->info("Need to get received balance rather than current balance");
      if (!isset($data['totalreceived'])) {
        throw new BalanceException("No totalreceived found");
      }
      $balance = $data['totalreceived'];
    } else {
      if (!isset($data['balance'])) {
        throw new BalanceException("No balance found");
      }
      $balance = $data['balance'];
    }

    $logger->info("Blockchain balance for $address: " . $balance);

    return $balance;
  }

  function getBlockCount(Logger $logger) {
    if (!$this->block_url) {
      throw new BlockException("No known block URL for currency '" . $this->currency->getCode() . "'");
    }

    $url = $this->block_url;

    $logger->info($url);
    $json = Fetch::jsonDecode(Fetch::get($url));
    try {
      $data = Fetch::checkJSend($json);
    } catch (JSendException $e) {
      throw new BlockException($e->getMessage(), $e);
    }
    $value = $data['last_block']['nb'];
    $logger->info("Block count: " . number_format($value));
    return $value;
  }

  function getDifficulty(Logger $logger) {
    if (!$this->difficulty_url) {
      throw new DifficultyException("No known difficulty URL for currency '" . $this->currency->getCode() . "'");
    }

    $url = $this->difficulty_url;

    $logger->info($url);
    $json = Fetch::jsonDecode(Fetch::get($url));
    try {
      $data = Fetch::checkJSend($json);
    } catch (JSendException $e) {
      throw new BlockException($e->getMessage(), $e);
    }
    $value = $data['last_block']['difficulty'];
    $logger->info("Difficulty: " . number_format($value));
    return $value;
  }

}
