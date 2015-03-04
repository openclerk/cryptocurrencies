<?php

namespace Cryptocurrency;

use \Monolog\Logger;
use \Openclerk\Currencies\Cryptocurrency;
use \Openclerk\Currencies\BlockCurrency;
use \Openclerk\Currencies\BlockBalanceableCurrency;
use \Openclerk\Currencies\DifficultyCurrency;
use \Openclerk\Currencies\ConfirmableCurrency;
use \Openclerk\Currencies\ReceivedCurrency;
use \Openclerk\Currencies\HashableCurrency;

/**
 * Represents the Worldcoin cryptocurrency.
 */
class Worldcoin extends Cryptocurrency
  implements BlockCurrency, DifficultyCurrency, ReceivedCurrency {

  function getCode() {
    return "wdc";
  }

  function getName() {
    return "Worldcoin";
  }

  function getURL() {
    return "http://www.worldcoinalliance.net/";
  }

  function getCommunityLinks() {
    return array(
      "http://www.worldcoinalliance.net/worldcoin-features-specifications-advantages/" => "Why Worldcoin?",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "W")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "Worldcoin Explorer";
  }

  function getExplorerURL() {
    return "http://www.worldcoinexplorer.com";
  }

  function getBalanceURL($address) {
    return sprintf("http://www.worldcoinexplorer.com/Explorer/Address/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\WorldcoinExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\WorldcoinExplorer();
    return $fetcher->getBalance($address, $logger, true);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\WorldcoinExplorer();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\WorldcoinExplorer();
    return $fetcher->getDifficulty($logger);
  }

}
