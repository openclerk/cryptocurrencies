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
 * Represents the Nxt cryptocurrency.
 */
class Nxt extends Cryptocurrency
  implements BlockCurrency, ReceivedCurrency {

  function getCode() {
    return "nxt";
  }

  function getName() {
    return "Nxt";
  }

  function getURL() {
    return "http://nxt.org/";
  }

  function getCommunityLinks() {
    return array(
      "http://nxt.org/get-started/" => "Get Started",
    );
  }

  /**
   * We support NXT addresses by numeric value only.
   */
  function isValid($address) {
    if (strlen($address) >= 5 && strlen($address) <= 32 && preg_match("#^[0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "myNXT.info";
  }

  function getExplorerURL() {
    return "http://www.mynxt.info/";
  }

  function getBalanceURL($address) {
    return sprintf("http://www.mynxt.info/blockexplorer/details.php?action=ac&ac=%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\MyNxtInfo();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\MyNxtInfo();
    return $fetcher->getBalance($address, $logger, true);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\MyNxtInfo();
    return $fetcher->getBlockCount($logger);
  }

}
