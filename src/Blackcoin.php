<?php

namespace Cryptocurrency;

use \Monolog\Logger;
use \Openclerk\Currencies\Cryptocurrency;
use \Openclerk\Currencies\BlockCurrency;
use \Openclerk\Currencies\BlockBalanceableCurrency;
use \Openclerk\Currencies\DifficultyCurrency;
use \Openclerk\Currencies\ConfirmableCurrency;
use \Openclerk\Currencies\ReceivedCurrency;

/**
 * Represents the Blackcoin cryptocurrency.
 */
class Blackcoin extends Cryptocurrency
  implements BlockCurrency, DifficultyCurrency, ReceivedCurrency {

  function getCode() {
    return "bc1";
  }

  function getName() {
    return "Blackcoin";
  }

  function getAbbr() {
    return "BLK";
  }

  function getURL() {
    return "http://www.blackcoin.co/";
  }

  function getCommunityLinks() {
    return array(
      "http://www.blackcoin.co/" => "What is Blackcoin?",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "B")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "BlackChain";
  }

  function getExplorerURL() {
    return "http://blackcha.in/";
  }

  function getBalanceURL($address) {
    return sprintf("http://blackcha.in/address/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\Blackchain();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\Blackchain();
    return $fetcher->getBalance($address, $logger, true);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\Blackchain();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\Blackchain();
    return $fetcher->getDifficulty($logger);
  }

}
