<?php

namespace Cryptocurrency\Services;

use \Monolog\Logger;
use \Apis\Fetch;
use \Apis\FetchException;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\Currency;
use \Openclerk\Currencies\BlockCurrency;

class EtherscanIo {

  function __construct() {
    $this->currency = new \Cryptocurrency\Ethereum();
    $this->url = "https://api.etherscan.io/api?module=account&action=balance&address=%s&tag=latest&apikey=YourApiKeyToken";
  }

  /**
   *
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger, $is_received = false) {
    $code = $this->currency->getCode();

    $url = sprintf($this->url, urlencode($address));
    $logger->info($url);

    try {
      $raw = Fetch::get($url);
    } catch (\Apis\FetchHttpException $e) {
      throw new BalanceException($e->getContent(), $e);
    }
    if (!$raw) {
      throw new BalanceException("Invalid address");
    }
    $json = Fetch::jsonDecode($raw);

    if ($json['status'] != "1") {
      throw new BalanceException("Could not fetch balance: " . htmlspecialchars($json["message"]));
    }

    $balance = $json['result'] / 1e18;

    $logger->info("Balance: " . $balance);
    return $balance;
  }

}
