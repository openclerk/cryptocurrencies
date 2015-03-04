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
 * Represents the Dogecoin cryptocurrency.
 */
class Dogecoin extends Cryptocurrency
  implements BlockCurrency, BlockBalanceableCurrency, DifficultyCurrency, ReceivedCurrency, HashableCurrency {

  function getCode() {
    return "dog";
  }

  function getName() {
    return "Dogecoin";
  }

  function getAbbr() {
    return "DOGE";
  }

  function getURL() {
    return "http://dogecoin.com/";
  }

  function getCommunityLinks() {
    return array(
      "https://dogecoin.org/" => "Dogecoin community",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "D")
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
    return "DogeChain";
  }

  function getExplorerURL() {
    return "http://dogechain.info/";
  }

  function getBalanceURL($address) {
    return sprintf("http://dogechain.info/address/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\Dogechain();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\Dogechain();
    return $fetcher->getBalance($address, $logger, true);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalanceAtBlock($address, $block, Logger $logger) {
    $fetcher = new Services\Dogechain();
    return $fetcher->getBalanceAtBlock($address, $block, $logger);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\Dogechain();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\Dogechain();
    return $fetcher->getDifficulty($logger);
  }

}
