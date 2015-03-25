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
 * Represents the Primecoin cryptocurrency.
 */
class Primecoin extends Cryptocurrency
  implements BlockCurrency, DifficultyCurrency, ReceivedCurrency {

  function getCode() {
    return "xpm";
  }

  function getName() {
    return "Primecoin";
  }

  function getURL() {
    return "http://primecoin.org/";
  }

  function getCommunityLinks() {
    return array(
      "https://github.com/primecoin/primecoin/wiki" => "Primecoin Wiki",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "A")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getService() {
    return new Services\PrimecoinExplorer();
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
