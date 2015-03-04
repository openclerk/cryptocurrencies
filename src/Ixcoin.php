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
 * Represents the Ixcoin cryptocurrency.
 */
class Ixcoin extends Cryptocurrency
  implements BlockCurrency, BlockBalanceableCurrency, DifficultyCurrency, ReceivedCurrency {

  function getCode() {
    return "ixc";
  }

  function getName() {
    return "Ixcoin";
  }

  function getURL() {
    return "http://ixcoin.org/";
  }

  function getCommunityLinks() {
    return array(
      "http://www.ixcoin.co/?page_id=18" => "Ixcoin Frequently Asked Questions",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "x")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "DarkGameX";
  }

  function getExplorerURL() {
    return "http://darkgamex.ch:2751/";
  }

  function getBalanceURL($address) {
    return sprintf("http://darkgamex.ch:2751/address/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\IxcoinExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\IxcoinExplorer();
    return $fetcher->getBalance($address, $logger, true);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalanceAtBlock($address, $block, Logger $logger) {
    $fetcher = new Services\IxcoinExplorer();
    return $fetcher->getBalanceAtBlock($address, $block, $logger);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\IxcoinExplorer();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\IxcoinExplorer();
    return $fetcher->getDifficulty($logger);
  }

}
