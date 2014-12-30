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

    Config::merge(array(
      "ltc_confirmations" => 6,
      "get_contents_timeout" => 5,
    ));
  }

  function testBalance() {
    $info = new LitecoinExplorer();
    $balance = $info->getBalance("LbYmauLERxK1vyqJbB9J2MNsffsYkBSuVX", $this->logger);
    $this->assertEquals(1, $balance);
  }

  function testReceived() {
    $info = new LitecoinExplorer();
    $balance = $info->getBalance("LbYmauLERxK1vyqJbB9J2MNsffsYkBSuVX", $this->logger, true);
    $this->assertEquals(1, $balance);
  }

  function testInvalidChecksum() {
    $info = new LitecoinExplorer();
    try {
      $balance = $info->getBalance("LbYmauLERxK1vyqJbB9J2MNsffsYkBSuV1", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Not a valid address/i", $e->getMessage());
    }
  }

  function testInvalidAddress() {
    $info = new LitecoinExplorer();
    try {
      $balance = $info->getBalance("invalid", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Not a valid address/i", $e->getMessage());
    }
  }

  function testBlockCount() {
    $info = new LitecoinExplorer();
    $value = $info->getBlockCount($this->logger);

    $this->assertGreaterThan(100, $value);
  }

  function testDifficulty() {
    $info = new LitecoinExplorer();
    $value = $info->getDifficulty($this->logger);

    $this->assertGreaterThan(1e3, $value);
  }

}
