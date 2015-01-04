<?php

namespace Cryptocurrency\Services;

use \Monolog\Logger;
use \Apis\Fetch;
use \Apis\FetchException;
use \Openclerk\Currencies\Currency;
use \Openclerk\Currencies\BlockCurrency;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\DifficultyException;
use \Openclerk\Currencies\BlockException;

/**
 * Explorers using Insight https://insight.is/
 */
abstract class AbstractInsightService {

  function __construct(Currency $currency, $args) {
    $this->currency = $currency;

    // default parameters
    $args += array(
      "info_url" => false,
    );

    $this->url = $args["url"];
    $this->info_url = $args["info_url"];
  }

  function getBalance($address, Logger $logger, $is_received = false) {

    $url = sprintf($this->url, urlencode($address));
    $logger->info($url);

    try {
      $text = Fetch::get($url);
      $result = Fetch::jsonDecode($text);
    } catch (FetchException $e) {
      if (preg_match("/invalid address/i", $text)) {
        throw new BalanceException("Invalid address", $e);
      } else {
        throw new BalanceException($e->getMessage(), $e);
      }
    }
    $logger->info(print_r($result, true));

    if (isset($result['error'])) {
      throw new BalanceException($result['error']);
    }

    if ($is_received) {
      $logger->info("We are looking for received balance.");

      $balance = $result['totalReceivedSat'];
      $divisor = 1e8;
    } else {
      $balance = $result['balanceSat'];
      $divisor = 1e8;
      // also available: totalSentSat, unconfirmedBalanceSat, taxAppearances, ...
    }

    $logger->info("Found balance " . ($balance / $divisor));

    return $balance / $divisor;
  }

  /**
   *
   * @throws {@link BlockException} if something happened and the balance could not be obtained.
   */
  function getBlockCount(Logger $logger) {
    $url = $this->info_url;

    $logger->info($url);
    try {
      $json = Fetch::jsonDecode(Fetch::get($url));
    } catch (FetchException $e) {
      throw new BlockException($e->getMessage(), $e);
    }

    if (!isset($json['info']['blocks'])) {
      throw new BlockException("Block number was not present");
    }
    $value = $json['info']['blocks'];
    $logger->info("Block count: " . number_format($value));

    return $value;
  }

  /**
   *
   * @throws {@link DifficultyException} if something happened and the balance could not be obtained.
   */
  function getDifficulty(Logger $logger) {
    $url = $this->info_url;

    $logger->info($url);
    $json = Fetch::jsonDecode(Fetch::get($url));

    if (isset($json['info']['difficulty']['proof-of-work'])) {
      $value = $json['info']['difficulty']['proof-of-work'];
    } else if (isset($json['info']['difficulty'])) {
      $value = $json['info']['difficulty'];
    } else {
      throw new DifficultyException("Difficulty was not present");
    }
    $logger->info("Difficulty: " . number_format($value));

    return $value;
  }

}
