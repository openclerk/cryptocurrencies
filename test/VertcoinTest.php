<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Vertcoin.
 */
class VertcoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Vertcoin());
  }

  function getInvalidAddress() {
    return "Vcvbcvbcvbcvbcvbxqv7xHV5oQH8iPhTr1";
  }

  function getBalanceAddress() {
    return "ViUu1mC7rQGFb54ixqv7xHV5oQH8iPhTrd";
  }

  function doTestBalance($balance) {
    $this->assertEquals(3301.70255715, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(158456.3730927, $balance);
  }

}
