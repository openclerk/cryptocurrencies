<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Dogecoin.
 */
class DogecoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Dogecoin());
  }

  function getInvalidAddress() {
    return "D64vbPp9TvqQ67xc6we5GnEtcKqiTXfp11";
  }

  function getBalanceAddress() {
    return "D64vbPp9TvqQ67xc6we5GnEtcKqiTXfp1S";
  }

  function doTestBalance($balance) {
    $this->assertEquals(300, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(300, $balance);
  }

  function getBalanceAtBlock() {
    return 104000;
  }

  function doTestBalanceAtBlock($balance) {
    $this->assertEquals(0, $balance);
  }

  function testInvalidAddress() {
    try {
      $balance = $this->currency->getBalance("invalid", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Not a valid address/i", $e->getMessage());
    }
  }

}
