<?php

namespace Cryptocurrency\Services;

use \Openclerk\Config;

/**
 * Represents something that can fetch Reddcoin statistics.
 *
 * TODO it may be possible to do confirmations
 */
class ReddcoinExplorer extends AbstractInsightService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Reddcoin(), array(
      "url" => "http://live.reddcoin.com/api/addr/%s/?noTxList=1",
      "info_url" => "http://live.reddcoin.com/api/status?q=getInfo",
    ));
  }

}
