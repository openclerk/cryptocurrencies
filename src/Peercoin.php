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
 * Represents the Peercoin cryptocurrency.
 */
class Peercoin extends Cryptocurrency
  implements BlockCurrency, DifficultyCurrency, ConfirmableCurrency, ReceivedCurrency, HashableCurrency {

  function getCode() {
    return "ppc";
  }

  function getName() {
    return "Peercoin";
  }

  function getURL() {
    return "http://ppcoin.org/";
  }

  function getCommunityLinks() {
    return array(
      "https://github.com/ppcoin/ppcoin/wiki/FAQ" => "Peercoin FAQ",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "P")
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
    return "Blockr.io";
  }

  function getExplorerURL() {
    return "http://ppc.blockr.io/";
  }

  function getBalanceURL($address) {
    return sprintf("http://ppc.blockr.io/address/info/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\PeercoinBlockr();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\PeercoinBlockr();
    return $fetcher->getBalance($address, $logger, true);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalanceWithConfirmations($address, $confirmations, Logger $logger) {
    $fetcher = new Services\PeercoinBlockr();
    return $fetcher->getBalanceWithConfirmations($address, $confirmations, $logger);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\PeercoinBlockr();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\PeercoinBlockr();
    return $fetcher->getDifficulty($logger);
  }

}
