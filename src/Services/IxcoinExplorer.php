<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;

class IxcoinExplorer extends AbstractAbeService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Ixcoin(), array(
      "url" => "http://darkgamex.ch:2751/address/%s",
      "block_url" => "http://darkgamex.ch:2751/chain/Ixcoin/q/getblockcount",
      "difficulty_url" => "http://darkgamex.ch:2751/chain/Ixcoin/q/getdifficulty",
      "confirmations" => 6,
    ));
  }

}
