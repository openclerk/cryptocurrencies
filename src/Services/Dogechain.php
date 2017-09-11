<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;
use \Monolog\Logger;

class Dogechain extends AbstractAbeService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Dogecoin(), array(
      "url" => "https://dogechain.info/address/%s",
      "block_url" => "https://dogechain.info/chain/Dogecoin/q/getblockcount",
      "difficulty_url" => "https://dogechain.info/chain/Dogecoin/q/getdifficulty",
      "confirmations" => 6,
    ));
  }

  // TODO remove ltc_address_url
  // TODO remove ltc_confirmations

  /**
   * No transactions were found; for Dogechain, this is OK.
   */
  function foundNoTransactions(Logger $logger) {
//    throw new BalanceException("Could not find any transactions on page");
  }

}
