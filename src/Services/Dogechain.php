<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;

class Dogechain extends AbstractAbeService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Dogecoin(), array(
      "url" => "http://dogechain.info/address/%s",
      "block_url" => "http://dogechain.info/chain/Dogecoin/q/getblockcount",
      "difficulty_url" => "http://dogechain.info/chain/Dogecoin/q/getdifficulty",
      "confirmations" => 6,
    ));
  }

  // TODO remove ltc_address_url
  // TODO remove ltc_confirmations

}
