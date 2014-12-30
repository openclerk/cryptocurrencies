<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Bitcoin.
 */
class BitcoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Bitcoin());
  }

  function getInvalidAddress() {
    return "1MbknviVk2tD6rFvDdiS1W6w4NJSfKEJG5";
  }

  function getBalanceAddress() {
    return "17eTMdqaFRSttfBYB9chKEzHubECZPTS6p";
  }

  function doTestBalance($balance) {
    $this->assertEquals(0.0301, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(0.0301, $balance);
  }

  function doTestBalanceWithConfirmations($balance) {
    $this->assertEquals(0.0301, $balance);
  }

  function getBalanceAtBlock() {
    return $this->currency->getBlockCount($this->logger) - 100;
  }

  function doTestBalanceAtBlock($balance) {
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

}
