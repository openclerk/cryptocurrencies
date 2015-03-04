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
 * Represents the Namecoin cryptocurrency.
 */
class Namecoin extends Cryptocurrency
  implements BlockCurrency, BlockBalanceableCurrency, DifficultyCurrency, ReceivedCurrency, HashableCurrency {

  function getCode() {
    return "nmc";
  }

  function getName() {
    return "Namecoin";
  }

  function getURL() {
    return "http://dot-bit.org/";
  }

  function getCommunityLinks() {
    return array(
      "http://dot-bit.org/Namecoin" => "What is Namecoin?",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "M" || substr($address, 0, 1) == "N")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  /**
   * Get the main algorithm used by this currency for hashing, as a
   * code from {@link HashAlgorithm#getCode()}.
   */
  public function getAlgorithm() {
    return "sha256";
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
    $fetcher = new Services\NamecoinExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalanceAtBlock($address, $block, Logger $logger) {
    $fetcher = new Services\NamecoinExplorer();
    return $fetcher->getBalanceAtBlock($address, $block, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\NamecoinExplorer();
    return $fetcher->getBalance($address, $logger, true);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\NamecoinExplorer();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\NamecoinExplorer();
    return $fetcher->getDifficulty($logger);
  }

}
