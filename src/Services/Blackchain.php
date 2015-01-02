<?php

namespace Cryptocurrency\Services;

use \Openclerk\Config;

/**
 * Represents something that can fetch Blackcoin statistics.
 */
class Blackchain extends AbstractInsightService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Darkcoin(), array(
      "url" => "http://blackcha.in/api/address/%s?noTxList=1",
      "info_url" => "http://blackcha.in/api/status?q=getInfo",
    ));
  }

}
