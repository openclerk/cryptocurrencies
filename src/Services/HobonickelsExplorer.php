<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;

class HobonickelsExplorer extends AbstractAbeService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Hobonickels(), array(
      "url" => "http://162.217.249.198:1080/address/%s",
      "block_url" => "http://162.217.249.198:1080/chain/Hobonickels/q/getblockcount",
      "difficulty_url" => "http://162.217.249.198:1080/chain/Hobonickels/q/getdifficulty",
      "confirmations" => 6,
    ));
  }

}
