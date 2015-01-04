<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;

class PeercoinBlockr extends AbstractBlockrService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Peercoin(), array(
      "url" => "http://ppc.blockr.io/api/v1/address/info/%s",
      "info_url" => "http://ppc.blockr.io/api/v1/coin/info",
      "confirmations" => 6,
    ));
  }

}
