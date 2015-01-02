<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;

class DarkcoinExplorer extends AbstractAbeService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Darkcoin(), array(
      "url" => "http://explorer.darkcoin.io/address/%s",
      "block_url" => "http://explorer.darkcoin.io/chain/Darkcoin/q/getblockcount",
      "difficulty_url" => "http://explorer.darkcoin.io/chain/Darkcoin/q/getdifficulty",
      "confirmations" => 6,
    ));
  }

}
