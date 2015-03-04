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
 * Represents the Storjcoin cryptocurrency.
 */
class Storjcoin extends Cryptocurrency {

  function getCode() {
    return "sj1";
  }

  function getName() {
    return "StorjCoin";
  }

  function getAbbr() {
    return "SJCX";
  }

  function getURL() {
    return "http://storj.io/";
  }

  function getCommunityLinks() {
    return array(
      "http://storj.io/faq.html" => "Storj Frequently Asked Questions",
    );
  }

  function isValid($address) {
    // very simple check according to https://bitcoin.it/wiki/Address
    if (strlen($address) >= 27 && strlen($address) <= 34 && ((substr($address, 0, 1) == "1" || substr($address, 0, 1) == "3"))
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "Blockscan";
  }

  function getExplorerURL() {
    return "https://blockscan.com/";
  }

  function getBalanceURL($address) {
    return sprintf("https://blockscan.com/address/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\Blockscan("SJCX");
    return $fetcher->getBalance($address, $logger);
  }


}
