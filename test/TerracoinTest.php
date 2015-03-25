<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Terracoin.
 */
class TerracoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Terracoin());
  }

  function getInvalidAddress() {
    return "15K9eY6bmu3hhaRqp8vcNknq7G1T59oJF1";
  }

  function getBalanceAddress() {
    return "15K9eY6bmu3hhaRqp8vcNknq7G1T59oJFR";
  }

  function doTestBalance($balance) {
    $this->assertEquals(0, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(404971.68357502, $balance);
  }

  /**
   * We can't actually test for invalid addresses using Coinplorer,
   * so we disable this test.
   */
  function testInvalidBalance() {
    $this->assertEquals("Coinplorer", $this->currency->getExplorerName());
  }
}
