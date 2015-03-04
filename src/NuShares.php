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
 * Represents the NuShares cryptocurrency.
 */
class NuShares extends Cryptocurrency
  implements BlockCurrency, DifficultyCurrency, ReceivedCurrency {

  function getCode() {
    return "nsr";
  }

  function getName() {
    return "NuShares";
  }

  function getURL() {
    return "https://nubits.com/nushares/introduction";
  }

  function getCommunityLinks() {
    return array(
    );
  }

  function isValid($address) {
    // based on is_valid_btc_address
    if (strlen($address) >= 27 && strlen($address) <= 34 && (substr($address, 0, 1) == "S")
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "NuExplorer";
  }

  function getExplorerURL() {
    return "https://blockexplorer.nu/";
  }

  function getBalanceURL($address) {
    return sprintf("https://blockexplorer.nu/address/%s/1/newest", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\NuSharesExplorer();
    return $fetcher->getBalance($address, $logger);
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getReceived($address, Logger $logger) {
    $fetcher = new Services\NuSharesExplorer();
    return $fetcher->getBalance($address, $logger, true);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\NuSharesExplorer();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\NuSharesExplorer();
    return $fetcher->getDifficulty($logger);
  }

}
