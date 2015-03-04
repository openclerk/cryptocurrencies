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
 * Represents the Novacoin cryptocurrency.
 */
class Novacoin extends Cryptocurrency
  implements BlockCurrency, DifficultyCurrency {

  function getCode() {
    return "nvc";
  }

  function getName() {
    return "Novacoin";
  }

  function getURL() {
    return "http://novacoin.org/";
  }

  function getCommunityLinks() {
    return array(
      "http://novacoin.org/wiki/" => "Novacoin Wiki",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "4")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "Novacoin Explorer";
  }

  function getExplorerURL() {
    return "https://explorer.novaco.in/";
  }

  function getBalanceURL($address) {
    return sprintf("https://explorer.novaco.in/address/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\NovacoinExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\NovacoinExplorer();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\NovacoinExplorer();
    return $fetcher->getDifficulty($logger);
  }

}
