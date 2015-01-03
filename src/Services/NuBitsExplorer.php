<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;

class NuBitsExplorer extends AbstractNuExplorerService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\NuBits(), array(
      "url" => "https://blockexplorer.nu/api/addressInfo/%s",
      "info_url" => "https://blockexplorer.nu/api/statusInfo/",
    ));
  }

}
