<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;

class MegacoinBlockr extends AbstractBlockrService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Megacoin(), array(
      "url" => "http://mec.blockr.io/api/v1/address/info/%s",
      "info_url" => "http://mec.blockr.io/api/v1/coin/info",
      "confirmations" => 6,
    ));
  }

}
