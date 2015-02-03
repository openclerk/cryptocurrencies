<?php

namespace Cryptocurrency;

use \Monolog\Logger;
use \Openclerk\Currencies\Cryptocurrency;
use \Openclerk\Currencies\BlockCurrency;
use \Openclerk\Currencies\BlockBalanceableCurrency;
use \Openclerk\Currencies\DifficultyCurrency;
use \Openclerk\Currencies\ConfirmableCurrency;
use \Openclerk\Currencies\ReceivedCurrency;

/**
 * Represents the Hobonickels cryptocurrency.
 */
class Hobonickels extends Cryptocurrency
  implements BlockCurrency, DifficultyCurrency {

  function getCode() {
    return "hbn";
  }

  function getName() {
    return "HoboNickels";
  }

  function getURL() {
    return "http://hobonickels.info/";
  }

  function getCommunityLinks() {
    return array(
      "http://hobonickels.info/community.php" => "HoboNickels Community",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "E" || substr($address, 0, 1) == "F")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "Hobonickels Explorer";
  }

  function getExplorerURL() {
    return "http://hbn.cryptocoinexplorer.com/";
  }

  function getBalanceURL($address) {
    return sprintf("http://hbn.cryptocoinexplorer.com/address?address=%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\HobonickelsExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\HobonickelsExplorer();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\HobonickelsExplorer();
    return $fetcher->getDifficulty($logger);
  }

}
