<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Primecoin.
 */
class PrimecoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Primecoin());
  }

  function getInvalidAddress() {
    return "AVDEwDdQGR4CLLqn2JAypC9zRVriyJadL1";
  }

  function getBalanceAddress() {
    return "AVDEwDdQGR4CLLqn2JAypC9zRVriyJadLz";
  }

  function doTestBalance($balance) {
    $this->assertEquals(295005.71475711, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(363864.22914168, $balance);
  }

  /**
   * We can't actually test for invalid addresses using Coinplorer,
   * so we disable this test.
   */
  function testInvalidBalance() {
    // empty
  }
}
