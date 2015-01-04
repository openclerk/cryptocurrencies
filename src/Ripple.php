<?php

namespace Cryptocurrency;

use \Monolog\Logger;
use \Openclerk\Currencies\Cryptocurrency;
use \Openclerk\Currencies\BlockCurrency;
use \Openclerk\Currencies\BlockBalanceableCurrency;
use \Openclerk\Currencies\DifficultyCurrency;
use \Openclerk\Currencies\ConfirmableCurrency;
use \Openclerk\Currencies\ReceivedCurrency;
use \Openclerk\Currencies\MultiBalanceableCurrency;

/**
 * Represents the Ripple cryptocurrency.
 */
class Ripple extends Cryptocurrency
  implements MultiBalanceableCurrency {

  function getCode() {
    return "xrp";
  }

  function getName() {
    return "Ripple";
  }

  function getURL() {
    return "https://ripple.com/";
  }

  function getCommunityLinks() {
    return array(
      "https://ripple.com/about-ripple/" => "What is Ripple?",
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "r")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "Ripple Charts";
  }

  function getExplorerURL() {
    return "https://www.ripplecharts.com/#/graph";
  }

  function getBalanceURL($address) {
    return sprintf("https://ripple.com/graph/#%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\RippleExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getMultiBalances($address, Logger $logger) {
    $fetcher = new Services\RippleExplorer();
    return $fetcher->getBalances($address, $logger);
  }

}
