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
    $this->assertEquals(0.14037, $balance);
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
