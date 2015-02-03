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
 * Explorers using CryptoCoinExplorer http://www.cryptocoinexplorer.com/api
 * While there is a 'ledgers' API, this only returns time/tx/amount and not block number,
 * so we cannot calculate Received Balance for an address.
 */
abstract class AbstractCryptoCoinExplorerService {

  function __construct(Currency $currency, $args) {
    $this->currency = $currency;

    $this->url = $args["url"];
  }

  /**
   * There is no API that returns transactions for a given address.
   *
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $url = sprintf("%sbalance/%s", $this->url, $address);

    $logger->info($url);
    $json = Fetch::jsonDecode(Fetch::get($url));
    if ($json === "error") {
      throw new BalanceException("Not a valid address");
    }
    $value = $json['balance'];
    $logger->info("Balance: " . $value);

    return $value;
  }

  /**
   *
   * @throws {@link BlockException} if something happened and the balance could not be obtained.
   */
  function getBlockCount(Logger $logger) {
    $url = sprintf("%sblock/-1", $this->url);

    $logger->info($url);
    $json = Fetch::jsonDecode(Fetch::get($url));
    $value = $json['height'];
    $logger->info("Block count: " . number_format($value));

    return $value;
  }

  /**
   *
   * @throws {@link DifficultyException} if something happened and the balance could not be obtained.
   */
  function getDifficulty(Logger $logger) {
    $url = sprintf("%sdifficulty", $this->url);

    $logger->info($url);
    $json = Fetch::jsonDecode(Fetch::get($url));
    $value = $json['difficulty'];
    $logger->info("Difficulty: " . number_format($value));

    return $value;
  }

}
