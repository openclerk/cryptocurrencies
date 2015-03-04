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
 * Represents the Terracoin cryptocurrency.
 */
class Terracoin extends Cryptocurrency
  implements BlockCurrency, DifficultyCurrency, ReceivedCurrency, HashableCurrency {

  function getCode() {
    return "trc";
  }

  function getName() {
    return "Terracoin";
  }

  function getURL() {
    return "http://terracoin.org/";
  }

  function getCommunityLinks() {
    return array(
      "http://terracoin.sourceforge.net/about.html" => "About Terracoin",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && ((substr($address, 0, 1) == "1" || substr($address, 0, 1) == "3"))
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
    return "Coinplorer";
  }

  function getExplorerURL() {
    return "https://coinplorer.com/TRC";
  }

  function getBalanceURL($address) {
    return sprintf("https://coinplorer.com/TRC/Addresses/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\TerracoinExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\TerracoinExplorer();
    return $fetcher->getBalance($address, $logger, true);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\TerracoinExplorer();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\TerracoinExplorer();
    return $fetcher->getDifficulty($logger);
  }

}
