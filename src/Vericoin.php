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
 * Represents the Vericoin cryptocurrency.
 */
class Vericoin extends Cryptocurrency
  implements BlockCurrency, DifficultyCurrency, ReceivedCurrency {

  function getCode() {
    return "vrc";
  }

  function getName() {
    return "Vericoin";
  }

  function getURL() {
    return "http://www.vericoin.info/";
  }

  function getCommunityLinks() {
    return array(
      "https://www.vericoin.info/community.html" => "Vericoin Community",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "V")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getService() {
    return new Services\VericoinExplorer();
  }

  function getExplorerName() {
    return $this->getService()->getExplorerName();
  }

  function getExplorerURL() {
    return $this->getService()->getExplorerURL();
  }

  function getBalanceURL($address) {
    return $this->getService()->getBalanceURL($address);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = $this->getService();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = $this->getService();
    return $fetcher->getBalance($address, $logger, true);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = $this->getService();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = $this->getService();
    return $fetcher->getDifficulty($logger);
  }

}
