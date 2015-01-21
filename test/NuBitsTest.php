<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of NuBits.
 */
class NuBitsTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\NuBits());
  }

  function getInvalidAddress() {
    return "BFree3gZJDHm1u2VQw4JyTDsF44sj9UcN1";
  }

  function getBalanceAddress() {
    return "BFree3gZJDHm1u2VQw4JyTDsF44sj9UcNr";
  }

  function doTestBalance($balance) {
    $this->assertGreaterThan(0.25, $balance);
  }

  function doTestReceived($balance) {
    $this->assertGreaterThan(1659.0918, $balance);
  }

  function testInvalidAddress() {
    try {
      $balance = $this->currency->getBalance("invalid", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Address does not exist/i", $e->getMessage());
    }
  }

}
