<?php

namespace Cryptocurrency\Tests;

use Monolog\Logger;
use Openclerk\Config;
use Cryptocurrency\Services\LitecoinExplorer;

/**
 * Test the implementation of Litecoin.
 */
class LitecoinTest extends \PHPUnit_Framework_TestCase {

  function __construct() {
    $this->logger = new Logger("test");
    $this->currency = new \Cryptocurrency\Litecoin();

    Config::merge(array(
      "ltc_confirmations" => 6,
      "get_contents_timeout" => 5,
    ));
  }

  function testValid() {
    $this->assertTrue($this->currency->isValid("LbYmauLERxK1vyqJbB9J2MNsffsYkBSuVX"), "LbYmauLERxK1vyqJbB9J2MNsffsYkBSuVX should be valid");
    $this->assertFalse($this->currency->isValid("invalid"), "invalid should be valid");
  }

  function testBalance() {
    $balance = $this->currency->getBalance("LbYmauLERxK1vyqJbB9J2MNsffsYkBSuVX", $this->logger);
    $this->assertEquals(1, $balance);
  }

  function testReceived() {
    $balance = $this->currency->getBalance("LbYmauLERxK1vyqJbB9J2MNsffsYkBSuVX", $this->logger, true);
    $this->assertEquals(1, $balance);
  }

  function testBalanceAtBlock() {
    $balance = $this->currency->getBalanceAtBlock("LbYmauLERxK1vyqJbB9J2MNsffsYkBSuVX", 515900, $this->logger);
    $this->assertEquals(1, $balance);
  }

  function testBalanceAtBlockZero() {
    $balance = $this->currency->getBalanceAtBlock("LbYmauLERxK1vyqJbB9J2MNsffsYkBSuVX", 514900, $this->logger);
    $this->assertEquals(0, $balance);
  }

  function testInvalidChecksum() {
    try {
      $balance = $this->currency->getBalance("LbYmauLERxK1vyqJbB9J2MNsffsYkBSuV1", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Not a valid address/i", $e->getMessage());
    }
  }

  function testInvalidAddress() {
    try {
      $balance = $this->currency->getBalance("invalid", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Not a valid address/i", $e->getMessage());
    }
  }

  function testBlockCount() {
    $value = $this->currency->getBlockCount($this->logger);

    $this->assertGreaterThan(100, $value);
  }

  function testDifficulty() {
    $value = $this->currency->getDifficulty($this->logger);

    $this->assertGreaterThan(1e3, $value);
  }

}
