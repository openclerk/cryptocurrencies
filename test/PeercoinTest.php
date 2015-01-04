<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Peercoin.
 */
class PeercoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Peercoin());
  }

  function getInvalidAddress() {
    return "PNGYQH5aSNDKCHSroXL2HqgDJTZab1mhT1";
  }

  function getBalanceAddress() {
    return "PNGYQH5aSNDKCHSroXL2HqgDJTZab1mhTQ";
  }

  function doTestBalance($balance) {
    $this->assertEquals(9.88, $balance);
  }

  function doTestBalanceWithConfirmations($balance) {
    $this->assertEquals(9.88, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(9.88, $balance);
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
