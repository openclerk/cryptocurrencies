<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Blackcoin.
 */
class BlackcoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Blackcoin());
  }

  function getInvalidAddress() {
    return "BGCiwF6J8VsMT6rQUiDvgjahWNC62nyZqZ";
  }

  function getBalanceAddress() {
    return "BGCiwF6J8VsMT6rQUiDvgjahWNC62nyZq3";
  }

  function doTestBalance($balance) {
    $this->assertEquals(0.0, $balance);
  }

  function doTestReceived($balance) {
    $this->assertGreaterThan(106, $balance);
  }

}
