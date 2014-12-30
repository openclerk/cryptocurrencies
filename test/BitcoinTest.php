<?php

namespace Cryptocurrency\Tests;

use Monolog\Logger;
use Openclerk\Config;
use Cryptocurrency\Services\BlockchainInfo;

/**
 * Test the implementation of Bitcoin.
 */
class BitcoinTest extends \PHPUnit_Framework_TestCase {

  function __construct() {
    $this->logger = new Logger("test");
    $this->currency = new \Cryptocurrency\Bitcoin();

    Config::merge(array(
      "btc_confirmations" => 6,
      "get_contents_timeout" => 5,
    ));
  }

  function testValid() {
    $this->assertTrue($this->currency->isValid("17eTMdqaFRSttfBYB9chKEzHubECZPTS6p"), "17eTMdqaFRSttfBYB9chKEzHubECZPTS6p should be valid");
    $this->assertFalse($this->currency->isValid("invalid"), "invalid should be valid");
  }

  function testBalance() {
    $balance = $this->currency->getBalance("17eTMdqaFRSttfBYB9chKEzHubECZPTS6p", $this->logger);
    $this->assertEquals(0.0301, $balance);
  }

  function testReceived() {
    $balance = $this->currency->getBalance("17eTMdqaFRSttfBYB9chKEzHubECZPTS6p", $this->logger, true);
    $this->assertEquals(0.0301, $balance);
  }

  function testBalanceAtBlock() {
    $balance = $this->currency->getBalanceAtBlock("17eTMdqaFRSttfBYB9chKEzHubECZPTS6p", $this->currency->getBlockCount($this->logger) - 100, $this->logger);
    $this->assertEquals(0.0301, $balance);
  }

  function testInvalidChecksum() {
    try {
      $balance = $this->currency->getBalance("1MbknviVk2tD6rFvDdiS1W6w4NJSfKEJG5", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Checksum does not validate/i", $e->getMessage());
    }
  }

  function testInvalidCharacter() {
    try {
      $balance = $this->currency->getBalance("17eTMdqaFRSttfBYB9chKEzHubECZPTS60", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Illegal character /i", $e->getMessage());
    }
  }

  function testInvalidAddress() {
    try {
      $balance = $this->currency->getBalance("invalid", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Illegal character /i", $e->getMessage());
    }
  }

  function testBlockCount() {
    $value = $this->currency->getBlockCount($this->logger);

    $this->assertGreaterThan(100, $value);
  }

  function testDifficulty() {
    $value = $this->currency->getDifficulty($this->logger);

    $this->assertGreaterThan(1e6, $value);
  }

}
