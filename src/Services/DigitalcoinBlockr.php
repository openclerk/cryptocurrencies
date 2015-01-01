<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;

class DigitalcoinBlockr extends AbstractBlockrService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Litecoin(), array(
      "url" => "http://dgc.blockr.io/api/v1/address/info/%s",
      "block_url" => "http://dgc.blockr.io/api/v1/coin/info",
      "difficulty_url" => "http://dgc.blockr.io/api/v1/coin/info",
      "confirmations" => 6,
    ));
  }

}
