<?php

namespace Cryptocurrency\Services;

use \Monolog\Logger;
use \Apis\Fetch;
use \Apis\FetchException;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\Currency;
use \Openclerk\Currencies\BlockCurrency;

/**
 * Implements some common HTML stripping functionality for various services.
 */
abstract class AbstractHTMLService {

  function stripHTML($html) {
    $html = preg_replace("#[\n\t]+#", "", $html);
    $html = preg_replace("#</tr>#", "</tr>\n", $html);
    $html = preg_replace("#<td[^>]+?>#", "<td>", $html);
    $html = preg_replace("#<tr[^>]+?>#", "<tr>", $html);
    $html = preg_replace("#<span[^>]+?>#", "", $html);
    $html = preg_replace("#</span>#", "", $html);
    $html = preg_replace("#</?(b|i|em|strong)>#", "", $html);
    $html = preg_replace("#> *<#", "><", $html);

    return $html;
  }

}
