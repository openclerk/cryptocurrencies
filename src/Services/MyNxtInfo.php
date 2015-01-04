<?php

namespace Cryptocurrency\Services;

use \Monolog\Logger;
use \Apis\Fetch;
use \Apis\FetchException;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\BlockException;
use \Openclerk\Currencies\Currency;

class MyNxtInfo {

  function __construct() {
    $this->currency = new \Cryptocurrency\Nxt();
    $this->url = "http://www.mynxt.info/blockexplorer/details.php?action=ac&ac=%s";
    $this->post_url = "http://www.mynxt.info/blockexplorer/ajax_json.php";
    $this->blocks_url = "http://www.mynxt.info/api/0.1/public/index.php/blocks?draw=1&skip=0&limit=1&orderBy=nm_height+desc";
  }

  /**
   *
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger, $is_received = false) {

    $code = $this->currency->getCode();

    if ($is_received) {
      // we use HTML scraping for received balance
      $logger->info("We are looking for received balance.");

      $url = sprintf($this->url, urlencode($address));
      $logger->info($url);

      $html = Fetch::get($url);

      $html = preg_replace("#[\n\t]+#", "", $html);
      $html = preg_replace("#</tr>#", "</tr>\n", $html);
      $html = preg_replace("#<td[^>]+?>#", "<td>", $html);
      $html = preg_replace("#<tr[^>]+?>#", "<tr>", $html);
      $html = preg_replace("#<span[^>]+?>#", "", $html);
      $html = preg_replace("#</span>#", "", $html);
      $html = preg_replace("#</?(b|i|em|strong)>#", "", $html);
      $html = preg_replace("#> *<#", "><", $html);

      $matches = false;
      if (preg_match("#Total Nxt in:?</td><td>([0-9\.]+)</td>#im", $html, $matches)) {
        $balance = $matches[1];
        $logger->info("Address balance: " . $balance);
        return $balance;
      } else {
        throw new BalanceException("Could not find received balance on page");
      }

    } else {
      // there is a POST JSON that we can use to get the final balance

      $url = $this->post_url;
      $logger->info($url);
      $post = array(
        "ac" => $address,
      );
      $logger->info("Posting " . print_r($post, true));

      $json = Fetch::jsonDecode(Fetch::post($url, $post));

      if (isset($json['balance'])) {
        $balance = $json['balance'];
        $logger->info("Address balance: " . $balance);
        return $balance;
      } else {
        throw new BalanceException("Could not find final balance on page");
      }
    }

  }

  function getBlockCount(Logger $logger) {
    $url = $this->blocks_url;
    $logger->info($url);

    $json = Fetch::jsonDecode(Fetch::get($url));

    if (isset($json['data'][0]['nm_height'])) {
      $value = $json['data'][0]['nm_height'];
      $logger->info("Block count: " . number_format($value));
    } else {
      throw new BlockException("Could not find block count for currency '" . $this->currency->getCode() . "'");
    }

    return $value;
  }

}
