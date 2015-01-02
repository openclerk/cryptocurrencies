<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Feathercoin.
 */
class FeathercoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Feathercoin());
  }

  function getInvalidAddress() {
    return "6yhuk17d9LcSgRkjidSoL5H8jNgx9KCA91";
  }

  function getBalanceAddress() {
    return "6yhuk17d9LcSgRkjidSoL5H8jNgx9KCA9P";
  }

  function doTestBalance($balance) {
    $this->assertEquals(16.27820373, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(16.27820373, $balance);
  }

}
