<?php

namespace Cryptocurrency\Services;

use \Openclerk\Config;

/**
 * Represents something that can fetch TerracoinExplorer statistics.
 *
 * TODO it may be possible to do confirmations
 */
class TerracoinExplorer extends AbstractCoinplorerService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Terracoin(), array(
      "url" => "https://coinplorer.com/TRC/Addresses/%s",
      "info_url" => "https://coinplorer.com/TRC",
    ));
  }

}
