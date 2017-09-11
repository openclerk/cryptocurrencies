<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Ethereum.
 */
class EthereumTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Ethereum());
  }

  function getInvalidAddress() {
    return "0x2910543af39aba0cd09dbb2d50200b3e800a63d0";
  }

  function getBalanceAddress() {
    return "0x2910543af39aba0cd09dbb2d50200b3e800a63d2";
  }

  function doTestBalance($balance) {
    $this->assertEquals(25610.670351616746038528, $balance);
  }

  function doTestBalanceWithConfirmations($balance) {
    $this->assertEquals(9.88, $balance);
  }

  /**
   * We can't actually test for invalid addresses using Etherscan.io,
   * so we disable this test.
   */
  function testInvalidBalance() {
    // empty
  }

}
