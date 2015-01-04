<?php

namespace Cryptocurrency\Services;

use \Monolog\Logger;
use \Apis\Fetch;
use \Apis\FetchException;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\Currency;
use \Openclerk\Currencies\BlockCurrency;

class WorldcoinExplorer {

  function __construct() {
    $this->currency = new \Cryptocurrency\Worldcoin();
    $this->url = "http://www.worldcoinexplorer.com/api/address/%s";
    $this->info_url = "http://www.worldcoinexplorer.com/api/coindetails";
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

    $url = sprintf($this->url, urlencode($address));
    $logger->info($url);

    $raw = Fetch::get($url);
    if (!$raw) {
      throw new BalanceException("Invalid address");
    }
    $json = Fetch::jsonDecode($raw);

    if ($is_received) {
      if (!isset($json['TotalReceived'])) {
        throw new BalanceException("Could not find received balance");
      }
      $balance = $json['TotalReceived'];
    } else {
      if (!isset($json['Balance'])) {
        throw new BalanceException("Could not find current balance");
      }
      $balance = $json['Balance'];
    }

    $logger->info("Balance: " . $balance);
    return $balance;
  }

  function getBlockCount(Logger $logger) {
    $url = $this->info_url;
    $logger->info($url);

    $json = Fetch::jsonDecode(Fetch::get($url));

    if (!isset($json['Blocks'])) {
      throw new BlockException("Could not find block height");
    }
    $value = $json['Blocks'];
    $logger->info("Block count: " . number_format($value));
    return $value;
  }

  function getDifficulty(Logger $logger) {
    $url = $this->info_url;
    $logger->info($url);

    $json = Fetch::jsonDecode(Fetch::get($url));

    if (!isset($json['Difficulty'])) {
      throw new DifficultyException("Could not find difficulty");
    }
    $value = $json['Difficulty'];
    $logger->info("Difficulty: " . number_format($value));
    return $value;
  }

}
