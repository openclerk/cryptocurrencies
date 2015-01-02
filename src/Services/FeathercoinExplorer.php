<?php

namespace Cryptocurrency\Services;

use \Openclerk\Config;

/**
 * Represents something that can fetch Feathercoin statistics.
 *
 * TODO it may be possible to do confirmations: see e.g. http://explorer.feathercoin.com/api/txs?address=71teELdzSy6hUzWwo1281wGixDUrcRmYNG&pageNum=0
 */
class FeathercoinExplorer extends AbstractInsightService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Darkcoin(), array(
      "url" => "http://explorer.feathercoin.com/api/addr/%s/?noTxList=1",
      "info_url" => "http://explorer.feathercoin.com/api/status?q=getInfo",
    ));
  }

}
