<?php

namespace Cryptocurrency\Tests;

use Monolog\Logger;
use Openclerk\Config;
use Openclerk\Currencies\Currency;

/**
 * Abstracts away common test functionality.
 */
abstract class AbstractCryptocurrencyTest extends \PHPUnit_Framework_TestCase {

  function __construct(Currency $currency) {
    $this->logger = new Logger("test");
    $this->currency = $currency;

    Config::merge(array(
      $currency->getCode() . "_confirmations" => 6,
      "get_contents_timeout" => 5,
    ));
  }

  abstract function getBalanceAddress();
  abstract function getInvalidAddress();
  abstract function doTestBalance($balance);
  abstract function doTestReceived($balance);
  abstract function getBalanceAtBlock();
  abstract function doTestBalanceAtBlock($balance);

  function testValid() {
    $this->assertTrue($this->currency->isValid($this->getBalanceAddress()), $this->getBalanceAddress() . " should be valid");
    $this->assertFalse($this->currency->isValid("invalid"), "invalid should be invalid");
  }

  function testBalance() {
    $balance = $this->currency->getBalance($this->getBalanceAddress(), $this->logger);
    $this->doTestBalance($balance);
  }

  function testReceived() {
    $balance = $this->currency->getBalance($this->getBalanceAddress(), $this->logger, true);
    $this->doTestReceived($balance);
  }

  function testBalanceAtBlock() {
    $balance = $this->currency->getBalanceAtBlock($this->getBalanceAddress(), $this->currency->getBlockCount($this->logger) - 100, $this->logger);
    $this->doTestBalanceAtBlock($balance);
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
    $value = $this->currency->getBlockCount($this->logger);
    $this->assertGreaterThan(100, $value);
  }

  function testDifficulty() {
    $value = $this->currency->getDifficulty($this->logger);
    $this->assertGreaterThan(100, $value);
  }

}
