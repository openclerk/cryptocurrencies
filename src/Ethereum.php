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
 * Represents the Ethereum cryptocurrency.
 */
class Ethereum extends Cryptocurrency {

  function getCode() {
    return "eth";
  }

  function getName() {
    return "Ethereum";
  }

  function getURL() {
    return "https://www.ethereum.org/";
  }

  function getCommunityLinks() {
    return array(
      "http://twitter.com/ethereumproject" => "Ethereum Twitter",
    );
  }

  function isValid($address) {
    if (strlen($address) >= 40 && strlen($address) <= 45
        && preg_match("#^0x[0-9a-f]+$#i", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getService() {
    return new Services\EtherscanIo();
  }

  function getExplorerName() {
    return "Etherscan.io";
  }

  function getExplorerURL() {
    return "https://etherscan.io";
  }

  function getBalanceURL($address) {
    return "https://etherscan.io/address/" . $address;
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = $this->getService();
    return $fetcher->getBalance($address, $logger);
  }

}
