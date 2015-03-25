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
 * Represents the Viacoin cryptocurrency.
 */
class Viacoin extends Cryptocurrency
  implements BlockCurrency, DifficultyCurrency, ReceivedCurrency {

  function getCode() {
    return "via";
  }

  function getName() {
    return "Viacoin";
  }

  function getURL() {
    return "http://viacoin.org/";
  }

  function getCommunityLinks() {
    return array(
      "http://www.reddit.com/r/viacoin" => "/r/viacoin",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "V")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "Chainz";
  }

  function getExplorerURL() {
    return "https://chainz.cryptoid.info/";
  }

  function getBalanceURL($address) {
    return sprintf("https://chainz.cryptoid.info/via/address.dws?%s.htm", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\ViacoinExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\ViacoinExplorer();
    return $fetcher->getBalance($address, $logger, true);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\ViacoinExplorer();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\ViacoinExplorer();
    return $fetcher->getDifficulty($logger);
  }

}
