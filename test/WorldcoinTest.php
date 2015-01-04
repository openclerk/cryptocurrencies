<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Worldcoin.
 */
class WorldcoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Worldcoin());
  }

  function getInvalidAddress() {
    return "WRhxyue7Nq27cKzwPfk5j4rAHJn75ArKe1";
  }

  function getBalanceAddress() {
    return "WRhxyue7Nq27cKzwPfk5j4rAHJn75ArKed";
  }

  function doTestBalance($balance) {
    $this->assertEquals(908061.38120779, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(2313581.06305750, $balance);
  }

}
