<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Netcoin.
 */
class NetcoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Netcoin());
  }

  function getInvalidAddress() {
    return "nMEkHkSaYLp7Aqjr8YSDsSvF4795LVmzi1";
  }

  function getBalanceAddress() {
    return "nMEkHkSaYLp7Aqjr8YSDsSvF4795LVmziQ";
  }

  function doTestBalance($balance) {
    $this->assertEquals(0, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(10.67430105, $balance);
  }

  function getBalanceAtBlock() {
    return 260440;
  }

  function doTestBalanceAtBlock($balance) {
    $this->assertEquals(10.67430105, $balance);
  }

  function testInvalidAddress() {
    try {
      $balance = $this->currency->getBalance("invalid", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Not a valid address/i", $e->getMessage());
    }
  }

}
