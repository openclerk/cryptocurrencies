<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of NuShares.
 */
class NuSharesTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\NuShares());
  }

  function getInvalidAddress() {
    return "STiiSEVpMhBug74F4V9dTQvBT3YsLAJJb1";
  }

  function getBalanceAddress() {
    return "STiiSEVpMhBug74F4V9dTQvBT3YsLAJJby";
  }

  function doTestBalance($balance) {
    $this->assertGreaterThan(9292000, $balance);
  }

  function doTestReceived($balance) {
    $this->assertGreaterThan(9292000, $balance);
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
