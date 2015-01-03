<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;

class NuSharesExplorer extends AbstractNuExplorerService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\NuShares(), array(
      "url" => "https://blockexplorer.nu/api/addressInfo/%s",
      "info_url" => "https://blockexplorer.nu/api/statusInfo/",
    ));
  }

}
