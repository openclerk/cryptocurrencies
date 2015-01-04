<?php

namespace Cryptocurrency\Services;

use \Monolog\Logger;
use \Apis\Fetch;
use \Apis\FetchException;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\Currency;
use \Openclerk\Currencies\BlockCurrency;

class NovacoinExplorer extends AbstractHTMLService {

  function __construct() {
    $this->currency = new \Cryptocurrency\Novacoin();
    $this->url = "https://explorer.novaco.in/address/%s";
    $this->blocks_url = "https://explorer.novaco.in/blocks/-1";
  }

  /**
   *
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {

    $code = $this->currency->getCode();

    $url = sprintf($this->url, urlencode($address));
    $logger->info($url);

    $html = Fetch::get($url);

    $matches = false;

    // look for 'current balance'
    if (preg_match("#Current balance:?</td><td>([0-9\.]+)</td>#im", $html, $matches)) {
      $balance = $matches[1];
      $logger->info("Address balance: " . $balance);
      return $balance;
    } else {
      throw new BalanceException("Could not find current balance on page");
    }

  }

  function getBlockCount(Logger $logger) {
    $url = $this->blocks_url;
    $logger->info($url);

    $html = Fetch::get($url);
    $html = $this->stripHTML($html);

    // number, hash, type, date, difficulty, transactions, ...
    if (preg_match('#<tr><td>([0-9]+)</td><td>.+?</td><td>(PoW|PoS)</td><td>([^<]+)</td><td>([0-9\\.]+)</td><td>([0-9]+)</td>#im', $html, $matches)) {
      $value = $matches[1];
      $logger->info("Block count: " . number_format($value));
    } else {
      throw new BlockException("Could not find block count for currency '" . $this->currency->getCode() . "'");
    }

    return $value;
  }

  /**
   * We return the Proof of Work difficulty for this currency.
   */
  function getDifficulty(Logger $logger) {
    $url = $this->blocks_url;
    $logger->info($url);

    $html = Fetch::get($url);
    $html = $this->stripHTML($html);

    // number, hash, type, date, difficulty, transactions, ...
    if (preg_match('#<tr><td>([0-9]+)</td><td>.+?</td><td>(PoW)</td><td>([^<]+)</td><td>([0-9\\.]+)</td><td>([0-9]+)</td>#im', $html, $matches)) {
      $value = $matches[4];
      $logger->info("Difficulty: " . number_format($value));
    } else {
      throw new BlockException("Could not find difficulty for currency '" . $this->currency->getCode() . "'");
    }

    return $value;
  }

}
