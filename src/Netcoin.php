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
 * Represents the Netcoin cryptocurrency.
 */
class Netcoin extends Cryptocurrency
  implements BlockCurrency, BlockBalanceableCurrency, DifficultyCurrency, ReceivedCurrency {

  function getCode() {
    return "net";
  }

  function getName() {
    return "Netcoin";
  }

  function getURL() {
    return "http://netcoinfoundation.org/";
  }

  function getCommunityLinks() {
    return array(
      "http://forum.netcoinfoundation.org/" => "Netcoin Forum",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "n")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "Netcoin Explorer";
  }

  function getExplorerURL() {
    return "http://explorer.netcoinfoundation.org/";
  }

  function getBalanceURL($address) {
    return sprintf("http://explorer.netcoinfoundation.org/address/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\NetcoinExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\NetcoinExplorer();
    return $fetcher->getBalance($address, $logger, true);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalanceAtBlock($address, $block, Logger $logger) {
    $fetcher = new Services\NetcoinExplorer();
    return $fetcher->getBalanceAtBlock($address, $block, $logger);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\NetcoinExplorer();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\NetcoinExplorer();
    return $fetcher->getDifficulty($logger);
  }

}
