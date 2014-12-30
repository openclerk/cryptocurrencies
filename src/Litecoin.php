<?php

namespace Cryptocurrency;

use \Monolog\Logger;

/**
 * Represents the Litecoin cryptocurrency.
 */
class Litecoin extends \Openclerk\Currencies\Cryptocurrency
  implements \Openclerk\Currencies\BlockCurrency, \Openclerk\Currencies\DifficultyCurrency {

  function getCode() {
    return "ltc";
  }

  function getName() {
    return "Litecoin";
  }

  function getURL() {
    return "http://bitcoin.org/";
  }

  function getCommunityLinks() {
    return array(
      "https://en.bitcoin.it/wiki/Litecoin" => "What is Litecoin?",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "L")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "Litecoin Explorer";
  }

  function getExplorerURL() {
    return "http://explorer.litecoin.net/";
  }

  function getBalanceURL($address) {
    return sprintf("http://explorer.litecoin.net/address/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\LitecoinExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalanceAtBlock($address, $block, Logger $logger) {
    $fetcher = new Services\LitecoinExplorer();
    return $fetcher->getBalanceAtBlock($address, $block, $logger);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\LitecoinExplorer();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\LitecoinExplorer();
    return $fetcher->getDifficulty($logger);
  }

}
