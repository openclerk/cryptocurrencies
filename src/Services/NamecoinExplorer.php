<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;

class NamecoinExplorer extends AbstractAbeService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Namecoin(), array(
      "url" => "http://darkgamex.ch:2751/address/%s",
      "block_url" => "http://darkgamex.ch:2751/chain/Namecoin/q/getblockcount",
      "difficulty_url" => "http://darkgamex.ch:2751/chain/Namecoin/q/getdifficulty",
      "confirmations" => 6,
    ));
  }

}
