<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Digitalcoin.
 */
class DigitalcoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Digitalcoin());
  }

  function getInvalidAddress() {
    return "D7BtQraYNfdXoUwenwrN3ivMSgncsS2mG1";
  }

  function getBalanceAddress() {
    return "D7BtQraYNfdXoUwenwrN3ivMSgncsS2mG8";
  }

  function doTestBalance($balance) {
    $this->assertEquals(421.4, $balance);
  }

  function doTestBalanceWithConfirmations($balance) {
    $this->assertEquals(421.4, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(552.5, $balance);
  }

  function testInvalidAddress() {
    try {
      $balance = $this->currency->getBalance("invalid", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Address is not valid/i", $e->getMessage());
    }
  }

}
