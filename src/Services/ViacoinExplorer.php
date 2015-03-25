<?php

namespace Cryptocurrency\Services;

use \Openclerk\Config;

/**
 * Represents something that can fetch Viacoin statistics.
 *
 * TODO it may be possible to do confirmations
 */
class ViacoinExplorer extends AbstractChainzService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Vericoin(), array(
      "url" => "http://chainz.cryptoid.info/via/api.dws?a=%s&q=getbalance",
      "received_url" => "http://chainz.cryptoid.info/via/api.dws?a=%s&q=getreceivedbyaddress",
      "block_url" => "http://chainz.cryptoid.info/via/api.dws?q=getblockcount",
      "difficulty_url" => "http://chainz.cryptoid.info/via/api.dws?q=getdifficulty",
    ));
  }

}
