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
    return "1EJf7RhWvb1LPMECiSt6aS3RpD7mfJQNaR";
  }

  function doTestBalance($balance) {
    $this->assertGreaterThanOrEqual(300, $balance);
  }

}
