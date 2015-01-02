<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Hobonickels.
 */
class HobonickelsTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Hobonickels());
  }

  function getInvalidAddress() {
    return "F1KM3Z51GFKUgAgPQ3nGFKQNNCGErTqyo1";
  }

  function getBalanceAddress() {
    return "F1KM3Z51GFKUgAgPQ3nGFKQNNCGErTqyoP";
  }

  function doTestBalance($balance) {
    $this->assertEquals(0.140333, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(1065.996373, $balance);
  }

  function getBalanceAtBlock() {
    return 1116400;
  }

  function doTestBalanceAtBlock($balance) {
    $this->assertEquals(0.140333 + 0.016472, $balance);
  }

  function testBalanceAtBlockZero() {
    $balance = $this->currency->getBalanceAtBlock($this->getBalanceAddress(), 500000, $this->logger);
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

  function expectedDifficulty() {
    // HBN seems to be a dead currency
    return 0.001;
  }

}
