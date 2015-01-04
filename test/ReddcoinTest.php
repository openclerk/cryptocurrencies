<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Reddcoin.
 */
class ReddcoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Reddcoin());
  }

  function getInvalidAddress() {
    return "RbRGNKehaWVZpjSKvjtGmWvEnfgSnV3Sj1";
  }

  function getBalanceAddress() {
    return "RbRGNKehaWVZpjSKvjtGmWvEnfgSnV3SjE";
  }

  function doTestBalance($balance) {
    $this->assertEquals(200000, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(932976790.3360204, $balance);
  }

}
