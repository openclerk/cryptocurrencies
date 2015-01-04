<?php

namespace Cryptocurrency\Services;

use \Monolog\Logger;
use \Apis\Fetch;
use \Apis\FetchException;
use \Openclerk\Currencies\BalanceException;
use \Openclerk\Currencies\Currency;
use \Openclerk\Currencies\BlockCurrency;

abstract class AbstractAbeService extends AbstractHTMLService {

  function __construct(Currency $currency, $args) {
    $this->currency = $currency;

    // default parameters
    $args += array(
      "confirmations" => 6,
      "block_url" => false,
      "difficulty_url" => false,
    );

    $this->url = $args["url"];
    $this->block_url = $args["block_url"];
    $this->difficulty_url = $args["difficulty_url"];
    $this->confirmations = $args["confirmations"];
  }

  /**
   * No transactions were found; possibly throw a {@link BalanceException}.
   */
  function foundNoTransactions(Logger $logger) {
    throw new BalanceException("Could not find any transactions on page");
  }

  /**
   *
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger, $is_received = false) {
    return $this->getBalanceAtBlock($address, null, $logger, $is_received);
  }

  /**
   * @param $block may be {@code null}
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalanceAtBlock($address, $block = null, Logger $logger, $is_received = false) {

    $code = $this->currency->getCode();

    if ($is_received) {
      $logger->info("We are looking for received balance.");
    }

    // do we have a block count?
    if ($this->currency instanceof BlockCurrency && !$block) {
      // TODO this needs to be cacheable between requests, otherwise we're going to end
      // up spamming services for block counts!
      $logger->info("Finding most recent block count...");
      $block = $this->currency->getBlockCount($logger) - $this->confirmations;
    }

    $logger->info("Ignoring blocks after block " . number_format($block));

    // we can now request the HTML page
    $url = sprintf($this->url, $address);
    $logger->info($url);
    $html = Fetch::get($url);
    $html = $this->stripHTML($html);

    // assumes that the page format will not change
    if (!$is_received && preg_match('#(<p>|<tr><th>|<tr><td>)Balance:?( |</th><td>|</td><td>)([0-9\.]+) ' . $this->currency->getAbbr() . '#im', $html, $matches)) {
      $balance = $matches[3];
      $logger->info("Address balance before removing unconfirmed: " . $balance);

      // transaction, block, date, amount, [balance,] currency
      if (preg_match_all('#<tr><td>.+</td><td><a href=[^>]+>([0-9]+)</a></td><td>.+?</td><td>(- |\\+ |)([0-9\\.\\(\\)]+)</td>(|<td>([0-9\\.]+)</td>)<td>' . $this->currency->getAbbr() . '</td></tr>#im', $html, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
          if ($match[1] >= $block) {
            // too recent
            $amount = $match[3];
            if (substr($amount, 0, 1) == "(" && substr($amount, -1) == ")") {
              // convert (1.23) into -1.23
              $amount = - substr($amount, 1, strlen($amount) - 2);
            }
            if ($match[2] == "+ ") {
              $amount = +$amount;
            } else if ($match[2] == "- ") {
              $amount = -$amount;
            }
            $logger->info("Removing " . $amount . " from balance: unconfirmed (block " . $match[1] . " >= " . $block . ")");
            $balance -= $amount;
          }
        }

        $logger->info("Confirmed balance after " . $this->confirmations . " confirmations: " . $balance);

      } else {
        $this->foundNoTransactions($logger);
      }

    } else if ($is_received && preg_match('#(|<tr><th>|<tr><td>)Received:?( |</th><td>|</td><td>)([0-9\.]+) ' . $this->currency->getAbbr() . '#i', $html, $matches)) {
      $balance = $matches[3];
      $logger->info("Address received before removing unconfirmed: " . $balance);

      // transaction, block, date, amount, [balance,] currency
      if (preg_match_all('#<tr><td>.+</td><td><a href=[^>]+>([0-9]+)</a></td><td>.+?</td><td>(- |\\+ |)([0-9\\.\\(\\)]+)</td>(|<td>([0-9\\.]+)</td>)<td>' . $this->currency->getAbbr() . '</td></tr>#im', $html, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
          if ($match[1] >= $block) {
            // too recent
            $amount = $match[3];
            if (substr($amount, 0, 1) == "(" && substr($amount, -1) == ")") {
              // convert (1.23) into -1.23
              $amount = - substr($amount, 1, strlen($amount) - 2);
            }
            if ($match[2] == "+ ") {
              $amount = +$amount;
            } else if ($match[2] == "- ") {
              $amount = -$amount;
            }
            // only consider received
            if ($amount > 0) {
              $logger->info("Removing " . $amount . " from received: unconfirmed (block " . $match[1] . " >= " . $block . ")");
              $balance -= $amount;
            }
          }
        }

        $logger->info("Confirmed received after " . $this->confirmations . " confirmations: " . $balance);

      } else {
        $this->foundNoTransactions($logger);
      }

    } else if (strpos($html, "Address not seen on the network.") !== false) {
      // the address is valid, it just doesn't have a balance
      $balance = 0;
      $logger->info("Address is valid, but not yet seen on network");

    } else if (strpos($html, "Not a valid address.") !== false || strpos($html, "Please enter search terms") !== false) {
      // the address is NOT valid
      throw new BalanceException("Not a valid address");

    } else if (strpos($html, "this address has too many records to display") !== false) {
      // this address is valid, and it has a balance, but it has too many records for this Abe instance
      crypto_log("Address is valid, but has too many records to display");
      throw new BalanceException("Address has too many transactions");

    } else if (strpos(strtolower($html), "500 internal server error") !== false) {
      crypto_log("Server returned 500 Internal Server Error");
      throw new BalanceException("Server returned 500 Internal Server Error");

    } else {
      throw new BalanceException("Could not find balance on page");
    }

    return $balance;

  }

  function getBlockCount(Logger $logger) {
    if (!$this->block_url) {
      throw new BlockException("No known block URL for currency '" . $this->currency->getCode() . "'");
    }

    $url = $this->block_url;

    $logger->info($url);
    $value = Fetch::get($url);
    $logger->info("Block count: " . number_format($value));
    return $value;
  }

  function getDifficulty(Logger $logger) {
    if (!$this->difficulty_url) {
      throw new DifficultyException("No known difficulty URL for currency '" . $this->currency->getCode() . "'");
    }

    $url = $this->difficulty_url;

    $logger->info($url);
    $value = Fetch::get($url);
    $logger->info("Difficulty: " . number_format($value));
    return $value;
  }

}
