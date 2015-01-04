<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Ripple.
 */
class RippleTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Ripple());
  }

  function getInvalidAddress() {
    return "rHDmTYEot15DNF1hP2DPQqYP3KfNVpfyh1";
  }

  function getBalanceAddress() {
    return "rHDmTYEot15DNF1hP2DPQqYP3KfNVpfyhB";
  }

  function doTestBalance($balance) {
    $this->assertEquals(100.045596, $balance);
  }

  function testMultiBalanceXRP() {
    $balances = $this->currency->getMultiBalances($this->getBalanceAddress(), $this->logger);
    $this->assertEquals(100.045596, $balances['xrp']);
  }

  function testMultiBalanceCNY() {
    $balances = $this->currency->getMultiBalances($this->getBalanceAddress(), $this->logger);
    $this->assertEquals(9.7117, $balances['cny']);
  }

  function testMultiBalanceUSD() {
    $balances = $this->currency->getMultiBalances($this->getBalanceAddress(), $this->logger);
    $this->assertEquals(0, $balances['usd']);
  }

}
