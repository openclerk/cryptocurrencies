<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Vericoin.
 */
class VericoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Vericoin());
  }

  function getInvalidAddress() {
    return "VHFTkykgXLm4Tnp7qk3VdAzY16Gjyd5vq1";
  }

  function getBalanceAddress() {
    return "VHFTkykgXLm4Tnp7qk3VdAzY16Gjyd5vqm";
  }

  function doTestBalance($balance) {
    $this->assertGreaterThan(3000, $balance);
  }

  function doTestReceived($balance) {
    $this->assertGreaterThanOrEqual(1551335.95566986, $balance);
  }

  function expectedDifficulty() {
    // VRC seems to be a dead currency
    return 0.001;
  }

  /**
   * We can't actually test for invalid addresses using Coinplorer,
   * so we disable this test.
   */
  function testInvalidBalance() {
    // empty
  }
}
