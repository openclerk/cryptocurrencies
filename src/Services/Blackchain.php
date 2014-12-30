<?php

namespace Cryptocurrency\Services;

use \Openclerk\Config;
use \Apis\Fetch;
use \Apis\FetchException;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\BlockException;
use \Openclerk\Currencies\DifficultyException;
use \Monolog\Logger;

/**
 * Represents something that can fetch Blackcoin statistics.
 */
class Blackchain {

  function getBalance($address, Logger $logger, $is_received = false) {

    $url = sprintf("http://blackcha.in/api/address/%s?noTxList=1", urlencode($address));
    $logger->info($url);

    try {
      $result = Fetch::jsonDecode(Fetch::get($url));
    } catch (FetchException $e) {
      throw new BalanceException($e->getMessage(), $e);
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
    $url = "http://blackcha.in/api/status?q=getInfo";

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
    $logger->info("Block count: " . $value);

    return $value;
  }

  /**
   *
   * @throws {@link DifficultyException} if something happened and the balance could not be obtained.
   */
  function getDifficulty(Logger $logger) {
    $url = "http://blackcha.in/api/status?q=getInfo";

    $logger->info($url);
    $json = Fetch::jsonDecode(Fetch::get($url));

    if (!isset($json['info']['difficulty']['proof-of-work'])) {
      throw new DifficultyException("Difficulty was not present");
    }
    $value = $json['info']['difficulty']['proof-of-work'];
    $logger->info("Difficulty: " . $value);

    return $value;
  }

}
