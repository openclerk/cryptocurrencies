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
 * Represents the Litecoin cryptocurrency.
 */
class Litecoin extends Cryptocurrency
  implements BlockCurrency, BlockBalanceableCurrency, DifficultyCurrency, ReceivedCurrency {

  function getCode() {
    return "ltc";
  }

  function getName() {
    return "Litecoin";
  }

  function getURL() {
    return "http://litecoin.org/";
  }

  function getCommunityLinks() {
    return array(
      "https://litecointalk.org/" => "LitecoinTalk",
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
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\LitecoinExplorer();
    return $fetcher->getBalance($address, $logger, true);
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
