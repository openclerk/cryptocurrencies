<?php

namespace Cryptocurrency\Services;

use \Openclerk\Config;

/**
 * Represents something that can fetch Feathercoin statistics.
 *
 * TODO it may be possible to do confirmations
 */
class FeathercoinExplorer extends AbstractCoinplorerService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Feathercoin(), array(
      "url" => "https://coinplorer.com/FTC/Addresses/%s",
      "info_url" => "https://coinplorer.com/FTC",
    ));
  }

}
