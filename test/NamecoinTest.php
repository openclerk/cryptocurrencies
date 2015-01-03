<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Namecoin.
 */
class NamecoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Namecoin());
  }

  function getInvalidAddress() {
    return "N7ZdQURKz79Zt7KHJh1nMDsjNvYdnASAM1";
  }

  function getBalanceAddress() {
    return "N7ZdQURKz79Zt7KHJh1nMDsjNvYdnASAMY";
  }

  function doTestBalance($balance) {
    $this->assertEquals(0, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(0.27, $balance);
  }

  function getBalanceAtBlock() {
    return 104000;
  }

  function doTestBalanceAtBlock($balance) {
    $this->assertEquals(0.27, $balance);
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
