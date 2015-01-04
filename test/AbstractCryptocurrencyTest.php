<?php

namespace Cryptocurrency\Tests;

use Monolog\Logger;
use Monolog\Handler\BufferHandler;
use Monolog\Handler\NullHandler;
use Monolog\Handler\ErrorLogHandler;
use Openclerk\Config;
use Openclerk\Currencies\Currency;

/**
 * Abstracts away common test functionality.
 */
abstract class AbstractCryptocurrencyTest extends \PHPUnit_Framework_TestCase {

  function __construct(Currency $currency) {
    $this->logger = new Logger("test");
    $this->currency = $currency;

    if ($this->isDebug()) {
      $this->logger->pushHandler(new BufferHandler(new ErrorLogHandler()));
    } else {
      $this->logger->pushHandler(new NullHandler());
    }

    Config::merge(array(
      $currency->getCode() . "_confirmations" => 6,
      "get_contents_timeout" => 10,
    ));
  }

  function isDebug() {
    global $argv;
    if (isset($argv)) {
      foreach ($argv as $value) {
        if ($value === "--debug" || $value === "--verbose") {
          return true;
        }
      }
    }
    return false;
  }

  abstract function getBalanceAddress();
  abstract function getInvalidAddress();
  abstract function doTestBalance($balance);

  // optional test methods based on Currency superclasses
  function doTestReceived($balance) {
    throw new \Exception("Need to implement doTestReceived() for a ReceivedCurrency");
  }
  function getBalanceAtBlock() {
    throw new \Exception("Need to implement getBalanceAtBlock() for a BlockBalanceableCurrency");
  }
  function getConfirmations() {
    return 6; // by default
  }
  function doTestBalanceAtBlock($balance) {
    throw new \Exception("Need to implement doTestBalanceAtBlock() for a BlockBalanceableCurrency");
  }
  function doTestBalanceWithConfirmations($balance) {
    throw new \Exception("Need to implement doTestBalanceWithConfirmations() for a ConfirmableCurrency");
  }

  function testValid() {
    $this->assertTrue($this->currency->isValid($this->getBalanceAddress()), $this->getBalanceAddress() . " should be valid");
    $this->assertFalse($this->currency->isValid("invalid"), "invalid should be invalid");
  }

  function testBalance() {
    $balance = $this->currency->getBalance($this->getBalanceAddress(), $this->logger);
    $this->doTestBalance($balance);
  }

  function testReceived() {
    if ($this->currency instanceof \Openclerk\Currencies\ReceivedCurrency) {
      $balance = $this->currency->getReceived($this->getBalanceAddress(), $this->logger);
      $this->doTestReceived($balance);
    }
  }

  function testBalanceAtBlock() {
    if ($this->currency instanceof \Openclerk\Currencies\BlockBalanceableCurrency) {
      $balance = $this->currency->getBalanceAtBlock($this->getBalanceAddress(), $this->getBalanceAtBlock(), $this->logger);
      $this->doTestBalanceAtBlock($balance);
    }
  }

  function testBalanceWithConfirmations() {
    if ($this->currency instanceof \Openclerk\Currencies\ConfirmableCurrency) {
      $balance = $this->currency->getBalanceWithConfirmations($this->getBalanceAddress(), $this->getConfirmations(), $this->logger);
      $this->doTestBalanceWithConfirmations($balance);
    }
  }

  function testInvalidBalance() {
    try {
      $balance = $this->currency->getBalance($this->getInvalidAddress(), $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      // expected
    }
  }

  function testBlockCount() {
    if ($this->currency instanceof \Openclerk\Currencies\BlockCurrency) {
      $value = $this->currency->getBlockCount($this->logger);
      $this->assertGreaterThan(100, $value);
    }
  }

  function expectedDifficulty() {
    return 10;
  }

  function testDifficulty() {
    if ($this->currency instanceof \Openclerk\Currencies\DifficultyCurrency) {
      $value = $this->currency->getDifficulty($this->logger);
      $this->assertGreaterThan($this->expectedDifficulty(), $value);
    }
  }

}
