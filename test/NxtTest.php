<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Nxt.
 */
class NxtTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Nxt());
  }

  /**
   * We can't actually test for invalid addresses using the Nxt Explorer,
   * so we disable this test.
   */
  function testInvalidBalance() {
    // empty
  }

  function getInvalidAddress() {
    return "6635869272840226491";
  }

  function getBalanceAddress() {
    return "6635869272840226493";
  }

  function doTestBalance($balance) {
    $this->assertEquals(1.54017875, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(371504248.60, $balance);
  }

}
