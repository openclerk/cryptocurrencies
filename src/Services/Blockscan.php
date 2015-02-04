<?php

namespace Cryptocurrency\Services;

use \Openclerk\Config;
use \Apis\Fetch;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\BlockException;
use \Openclerk\Currencies\DifficultyException;
use \Monolog\Logger;

/**
 * Represents the Blockscan service which returns counterparty assets.
 */
class Blockscan {

  function __construct($asset_name) {
    $this->asset_name = $asset_name;
  }

  function getBalance($address, Logger $logger) {
    $url = sprintf("http://api.blockscan.com/api2?module=address&action=balance&btc_address=%s&asset=%s", $address, $this->asset_name);

    $logger->info($url);
    $json = Fetch::jsonDecode(Fetch::get($url));

    if ($json['status'] == "error") {
      throw new BalanceException($json['message']);
    } else {
      $balance = $json['data'][0]['balance'];
    }

    $logger->info("Blockchain balance for " . htmlspecialchars($address) . ": " . $balance);

    return $balance;
  }

}
