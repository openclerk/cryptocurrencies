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
 * Represents the Feathercoin cryptocurrency.
 */
class Feathercoin extends Cryptocurrency
  implements BlockCurrency, DifficultyCurrency, ReceivedCurrency, HashableCurrency {

  function getCode() {
    return "ftc";
  }

  function getName() {
    return "Feathercoin";
  }

  function getURL() {
    return "https://www.feathercoin.com/";
  }

  function getCommunityLinks() {
    return array(
      "https://www.feathercoin.com/about/" => "About Feathercoin",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "6" || substr($address, 0, 1) == "7")
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
    return "scrypt";
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "Coinplorer";
  }

  function getExplorerURL() {
    return "https://coinplorer.com/FTC";
  }

  function getBalanceURL($address) {
    return sprintf("https://coinplorer.com/FTC/Addresses/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\FeathercoinExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\FeathercoinExplorer();
    return $fetcher->getBalance($address, $logger, true);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\FeathercoinExplorer();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\FeathercoinExplorer();
    return $fetcher->getDifficulty($logger);
  }

}
