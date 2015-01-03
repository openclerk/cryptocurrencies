<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Megacoin.
 */
class MegacoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Megacoin());
  }

  function getInvalidAddress() {
    return "MRQxyWELkiGQW8KgsyCnchdJseestpZnz1";
  }

  function getBalanceAddress() {
    return "MRQxyWELkiGQW8KgsyCnchdJseestpZnzo";
  }

  function doTestBalance($balance) {
    $this->assertEquals(100, $balance);
  }

  function doTestBalanceWithConfirmations($balance) {
    $this->assertEquals(100, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(100, $balance);
  }

  function testInvalidAddress() {
    try {
      $balance = $this->currency->getBalance("invalid", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Address is not valid/i", $e->getMessage());
    }
  }

}
