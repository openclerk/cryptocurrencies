<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;

class NetcoinExplorer extends AbstractAbeService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Netcoin(), array(
      "url" => "http://explorer.netcoinfoundation.org/address/%s",
      "block_url" => "http://explorer.netcoinfoundation.org/chain/Netcoin/q/getblockcount",
      "difficulty_url" => "http://explorer.netcoinfoundation.org/chain/Netcoin/q/getdifficulty",
      "confirmations" => 6,
    ));
  }

}
