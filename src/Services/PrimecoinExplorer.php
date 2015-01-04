<?php

namespace Cryptocurrency\Services;

use \Openclerk\Config;

/**
 * Represents something that can fetch Primecoin statistics.
 *
 * TODO it may be possible to do confirmations
 */
class PrimecoinExplorer extends AbstractCoinplorerService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Primecoin(), array(
      "url" => "https://coinplorer.com/XPM/Addresses/%s",
      "info_url" => "https://coinplorer.com/XPM",
    ));
  }

}
