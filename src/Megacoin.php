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
 * Represents the Megacoin cryptocurrency.
 */
class Megacoin extends Cryptocurrency
  implements BlockCurrency, DifficultyCurrency, ConfirmableCurrency, ReceivedCurrency {

  function getCode() {
    return "mec";
  }

  function getName() {
    return "Megacoin";
  }

  function getURL() {
    return "http://megacoin.co.nz/";
  }

  function getCommunityLinks() {
    return array(
      "http://www.megacoin.co.nz/about" => "About Megacoin",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "M")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "Blockr.io";
  }

  function getExplorerURL() {
    return "http://mec.blockr.io/";
  }

  function getBalanceURL($address) {
    return sprintf("http://mec.blockr.io/address/info/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\MegacoinBlockr();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\MegacoinBlockr();
    return $fetcher->getBalance($address, $logger, true);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalanceWithConfirmations($address, $confirmations, Logger $logger) {
    $fetcher = new Services\MegacoinBlockr();
    return $fetcher->getBalanceWithConfirmations($address, $confirmations, $logger);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\MegacoinBlockr();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\MegacoinBlockr();
    return $fetcher->getDifficulty($logger);
  }

}
