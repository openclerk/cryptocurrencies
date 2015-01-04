<?php

namespace Cryptocurrency\Services;

use \Openclerk\Config;

/**
 * Represents something that can fetch Viacoin statistics.
 *
 * TODO it may be possible to do confirmations
 */
class ViacoinExplorer extends AbstractInsightService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Viacoin(), array(
      "url" => "http://explorer.viacoin.org/api/addr/%s/?noTxList=1",
      "info_url" => "http://explorer.viacoin.org/api/status?q=getInfo",
    ));
  }

}
