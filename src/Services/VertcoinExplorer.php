<?php

namespace Cryptocurrency\Services;

use \Monolog\Logger;
use \Apis\Fetch;
use \Apis\FetchException;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\Currency;
use \Openclerk\Currencies\BlockCurrency;

class VertcoinExplorer {

  function __construct() {
    $this->currency = new \Cryptocurrency\Vertcoin();
    $this->url = "http://vtc.sovereignshare.com/exp/api/";
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

    $url = $this->url;
    $logger->info($url);

    $data = json_encode(array(
      "id" => 1,
      "jsonrpc" => 1,
      "method" => "getaddress",
      "params" => array(
        "address" => $address,
      )
    ));

    $json = Fetch::jsonDecode(Fetch::post($url, $data));

    if ($is_received) {
      if (!isset($json['result']['total_output'])) {
        throw new BalanceException("Could not find output balance");
      }
      $balance = $json['result']['total_output'] / 1e8;
    } else {
      if (!isset($json['result']['total_input'])) {
        throw new BalanceException("Could not find input balance");
      }
      if (!isset($json['result']['total_output'])) {
        throw new BalanceException("Could not find output balance");
      }
      $balance = ($json['result']['total_output'] - $json['result']['total_input']) / 1e8;
    }

    $logger->info("Balance: " . $balance);
    return $balance;
  }

  function getBlockCount(Logger $logger) {
    $url = $this->url;
    $logger->info($url);

    $data = json_encode(array(
      "id" => 1,
      "jsonrpc" => 1,
      "method" => "getblocks",
      "params" => array(
        "page" => 0,
      )
    ));

    $json = Fetch::jsonDecode(Fetch::post($url, $data));

    if (!isset($json['result'][0]['height'])) {
      throw new BlockException("Could not find block height");
    }
    $value = $json['result'][0]['height'];
    $logger->info("Block count: " . number_format($value));
    return $value;
  }

  function getDifficulty(Logger $logger) {
    $url = $this->url;
    $logger->info($url);

    $data = json_encode(array(
      "id" => 1,
      "jsonrpc" => 1,
      "method" => "getblocks",
      "params" => array(
        "page" => 0,
      )
    ));

    $json = Fetch::jsonDecode(Fetch::post($url, $data));

    if (!isset($json['result'][0]['diff'])) {
      throw new DifficultyException("Could not find difficulty");
    }
    $value = $json['result'][0]['diff'];
    $logger->info("Difficulty: " . number_format($value));
    return $value;
  }

}
