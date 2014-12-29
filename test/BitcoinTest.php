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

    Config::merge(array(
      "btc_confirmations" => 6,
      "get_contents_timeout" => 5,
    ));
  }

  function testBalance() {
    $info = new BlockchainInfo();
    $balance = $info->getBalance("17eTMdqaFRSttfBYB9chKEzHubECZPTS6p", $this->logger);
    $this->assertEquals(0.0301, $balance);
  }

  function testInvalidChecksum() {
    $info = new BlockchainInfo();
    try {
      $balance = $info->getBalance("17eTMdqaFRSttfBYB9chKEzHubECZPTS60", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Illegal character /i", $e->getMessage());
    }
  }

  function testInvalidAddress() {
    $info = new BlockchainInfo();
    try {
      $balance = $info->getBalance("invalid", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Illegal character /i", $e->getMessage());
    }
  }

  function testBlockCount() {
    $info = new BlockchainInfo();
    $value = $info->getBlockCount($this->logger);

    $this->assertGreaterThan(100, $value);
  }

  function testDifficulty() {
    $info = new BlockchainInfo();
    $value = $info->getDifficulty($this->logger);

    $this->assertGreaterThan(1e6, $value);
  }

}
