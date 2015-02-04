<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Litecoin.
 */
class LitecoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Litecoin());
  }

  function getInvalidAddress() {
    return "LbYmauLERxK1vyqJbB9J2MNsffsYkBSuV1";
  }

  function getBalanceAddress() {
    return "LbYmauLERxK1vyqJbB9J2MNsffsYkBSuVX";
  }

  function doTestBalance($balance) {
    $this->assertEquals(1, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(1, $balance);
  }

  function getBalanceAtBlock() {
    return 515900;
  }

  function testBalanceAtBlockZero() {
    $balance = $this->currency->getBalanceAtBlock($this->getBalanceAddress(), 514900, $this->logger);
    $this->assertEquals(0, $balance);
  }

  function doTestBalanceAtBlock($balance) {
    $this->assertEquals(1, $balance);
  }

  function testInvalidAddress() {
    try {
      $balance = $this->currency->getBalance("invalid", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Not a valid address/i", $e->getMessage());
      $this->assertNotRegExp("/</i", $e->getMessage(), "Should not have any HTML");
    }
  }

  function testAddressNotSeen() {
    try {
      $balance = $this->currency->getBalance("LSja8VGwpDhhjVqkiZUPk2vDzQp6J8STa5", $this->logger);
      $this->fail("Expected failure");
    } catch (\Openclerk\Currencies\BalanceException $e) {
      $this->assertRegExp("/Address not seen on the network/i", $e->getMessage());
      $this->assertNotRegExp("/</i", $e->getMessage(), "Should not have any HTML");
    }
  }

}
