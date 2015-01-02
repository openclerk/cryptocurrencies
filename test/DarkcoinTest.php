<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Darkcoin.
 */
class DarkcoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Darkcoin());
  }

  function getInvalidAddress() {
    return "Xuu3Rg1oWubR2y4B828poADTdxAGuCGFS1";
  }

  function getBalanceAddress() {
    return "Xuu3Rg1oWubR2y4B828poADTdxAGuCGFSd";
  }

  function doTestBalance($balance) {
    $this->assertEquals(0, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(0.0129, $balance);
  }

  function getBalanceAtBlock() {
    return 140000;
  }

  function doTestBalanceAtBlock($balance) {
    $this->assertEquals(0.0129, $balance);
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
