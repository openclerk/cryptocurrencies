<?php

namespace Cryptocurrency\Tests;

use Monolog\Logger;
use Monolog\Handler\BufferHandler;
use Monolog\Handler\NullHandler;
use Monolog\Handler\ErrorLogHandler;
use Openclerk\Config;
use Openclerk\Currencies\Currency;

/**
 * Tests the collection of defined cryptocurrencies for various
 * release tests based on {@code currencies.json}.
 */
class AllCryptocurrenciesTest extends \PHPUnit_Framework_TestCase {

  function testCodeUniqueness() {
    foreach ($this->getCurrencies() as $key => $classname) {
      $instance = new $classname;
      $this->assertUnique($instance->getCode(), $instance);
    }
  }

  function testAbbrUniqueness() {
    foreach ($this->getCurrencies() as $key => $classname) {
      $instance = new $classname;
      $this->assertUnique($instance->getAbbr(), $instance);
    }
  }

  function testNameUniqueness() {
    foreach ($this->getCurrencies() as $key => $classname) {
      $instance = new $classname;
      $this->assertUnique($instance->getName(), $instance);
    }
  }

  function getCurrencies() {
    return json_decode(file_get_contents(__DIR__ . "/../currencies.json"), true /* assoc */);
  }

  function setUp() {
    $this->unique_array = array();
  }

  function tearDown() {
    $this->unique_array = null;
  }

  function assertUnique($key, $instance) {
    if (isset($this->unique_array[$key])) {
      $this->fail("Found unique code '$key' twice for " . get_class($instance) . " and " . get_class($this->unique_array[$key]));
    }
    $this->unique_array[$key] = $instance;
  }

}
