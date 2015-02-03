<?php

namespace Cryptocurrency\Services;

use \Openclerk\Currencies\Currency;

class HobonickelsExplorer extends AbstractCryptoCoinExplorerService {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Hobonickels(), array(
      "url" => "http://hbn.cryptocoinexplorer.com/api/",
    ));
  }

}
