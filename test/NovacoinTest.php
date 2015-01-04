<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Novacoin.
 */
class NovacoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Novacoin());
  }

  /**
   * We can't actually test for invalid addresses using the Novacoin Explorer,
   * so we disable this test.
   */
  function testInvalidBalance() {
    // empty
  }

  function getInvalidAddress() {
    return "4MLYbuE4S8K6JyHGJ6i3gLnWeLW2yy1bQ1";
  }

  function getBalanceAddress() {
    return "4MLYbuE4S8K6JyHGJ6i3gLnWeLW2yy1bQq";
  }

  function doTestBalance($balance) {
    $this->assertEquals(268.533397, $balance);
  }

}
