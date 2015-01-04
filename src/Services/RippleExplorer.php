<?php

namespace Cryptocurrency\Services;

use \Monolog\Logger;
use \Apis\Fetch;
use \Apis\FetchException;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\Currency;
use \Openclerk\Currencies\BlockCurrency;

class RippleExplorer {

  function __construct() {
    $this->currency = new \Cryptocurrency\Ripple();
    $this->url = "http://s_west.ripple.com:51234/";
  }

  function getAccountBalance($address, Logger $logger) {
    $url = $this->url;
    $logger->info($url);
    $data = array(
      "method" => "account_info",
      "params" => array(
        array(
          "account" => $address,
          "strict" => true,
        ),
      ),
    );

    $json = Fetch::jsonDecode(Fetch::post($url, json_encode($data)));

    if (!isset($json['result'])) {
      throw new BalanceException("No result found");
    }

    if (isset($json['result']['error_message']) && $json['result']['error_message']) {
      throw new BalanceException("Ripple returned " . htmlspecialchars($json['result']['error_message']));
    }

    if (!isset($json['result']['account_data']['Balance'])) {
      throw new BalanceException("No balance found");
    }

    $balance = $json['result']['account_data']['Balance'];
    $divisor = 1e6;

    return $balance / $divisor;
  }

  function getAccountLines($address, Logger $logger) {
    $url = $this->url;
    $logger->info($url);
    $data = array(
      "method" => "account_lines",
      "params" => array(
        array(
          "account" => $address,
        ),
      ),
    );

    $json = Fetch::jsonDecode(Fetch::post($url, json_encode($data)));

    return $json['result']['lines'];
  }

  /**
   * Get all associated Ripple balances.
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalances($address, Logger $logger) {
    $result = array(
      'xrp' => $this->getAccountBalance($address, $logger),
    );

    // now look for other currencies (#242)
    foreach ($this->getAccountLines($address, $logger) as $line) {
      $cur = strtolower($line['currency']);
      if (!isset($result[$cur])) {
        $result[$cur] = 0;
      }

      $result[$cur] += $line['balance'];
    }

    foreach ($result as $currency => $balance) {
      $logger->info("Balance in $currency: $balance");
    }

    return $result;
  }

  /**
   * Get just the Ripple balance.
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $balance = $this->getAccountBalance($address, $logger);
    $logger->info("Balance: $balance");
    return $balance;
  }

}
