<?php

namespace Cryptocurrency\Tests;

/**
 * Test the implementation of Storjcoin.
 */
class StorjcoinTest extends AbstractCryptocurrencyTest {

  function __construct() {
    parent::__construct(new \Cryptocurrency\Storjcoin());
  }

  function getInvalidAddress() {
    return "16WhhnUUCZVvszFxsaCG3d6v77Qin1LErz";
  }

  function getBalanceAddress() {
    return "16WhhnUUCZVvszFxsaCG3d6v77Qin1LErQ";
  }

  function doTestBalance($balance) {
    $this->assertEquals(1118.2517999, $balance);
  }

}
