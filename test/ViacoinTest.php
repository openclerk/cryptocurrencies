<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Viacoin.
 */
class ViacoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Viacoin());
  }

  function getInvalidAddress() {
    return "VxpV5duYe1pUmkQjwzeg8mfficUzfPEXE1";
  }

  function getBalanceAddress() {
    return "VxpV5duYe1pUmkQjwzeg8mfficUzfPEXEV";
  }

  function doTestBalance($balance) {
    $this->assertGreaterThan(100, $balance);
  }

  function doTestReceived($balance) {
    $this->assertGreaterThanOrEqual(256.28689524, $balance);
  }

  /**
   * We can't actually test for invalid addresses using Chainz,
   * so we disable this test.
   */
  function testInvalidBalance() {
    $this->assertEquals("Chainz", $this->currency->getExplorerName());
  }

}
