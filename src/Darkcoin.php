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
 * Represents the Darkcoin cryptocurrency.
 */
class Darkcoin extends Cryptocurrency
  implements BlockCurrency, BlockBalanceableCurrency, DifficultyCurrency, ReceivedCurrency {

  function getCode() {
    return "drk";
  }

  function getName() {
    return "Darkcoin";
  }

  function getURL() {
    return "https://www.darkcoin.io/";
  }

  function getCommunityLinks() {
    return array(
      "https://www.darkcoin.io/community/" => "Darkcoin Community",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "X")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "Darkcoin Explorer";
  }

  function getExplorerURL() {
    return "http://explorer.darkcoin.io/";
  }

  function getBalanceURL($address) {
    return sprintf("http://explorer.darkcoin.io/address/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\DarkcoinExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\DarkcoinExplorer();
    return $fetcher->getBalance($address, $logger, true);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalanceAtBlock($address, $block, Logger $logger) {
    $fetcher = new Services\DarkcoinExplorer();
    return $fetcher->getBalanceAtBlock($address, $block, $logger);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\DarkcoinExplorer();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\DarkcoinExplorer();
    return $fetcher->getDifficulty($logger);
  }

}
