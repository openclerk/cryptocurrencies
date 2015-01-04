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
    $this->assertEquals(190.78825257, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(256.28689524, $balance);
  }

}
