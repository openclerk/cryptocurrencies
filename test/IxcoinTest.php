<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Ixcoin.
 */
class IxcoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Ixcoin());
  }

  function getInvalidAddress() {
    return "xowXLgLhWGNGr5q12TwggynR4z6RbvtSH1";
  }

  function getBalanceAddress() {
    return "xowXLgLhWGNGr5q12TwggynR4z6RbvtSHz";
  }

  function doTestBalance($balance) {
    $this->assertEquals(0, $balance);
  }

  function doTestReceived($balance) {
    $this->assertEquals(13.23873833, $balance);
  }

  function getBalanceAtBlock() {
    return 239400;
  }

  function doTestBalanceAtBlock($balance) {
    $this->assertEquals(13.23873833, $balance);
  }

}
