<?php

namespace Cryptocurrency\Algorithms;

use \Openclerk\Currencies\HashAlgorithm;
use \Openclerk\Currencies\HashAlgorithmInformation;

/**
 * The SHA-256 algorithm used in Bitcoin, Namecoin etc hashing.
 */
class SHA256 extends HashAlgorithm
    implements HashAlgorithmInformation {

  /**
   * Get the unique 1-32 character algorithm code for this algorithm,
   * e.g. 'sha256' or 'scrypt'. Must be lowercase. This is not visible to users.
   */
  public function getCode() {
    return "sha256";
  }

  /**
   * For some currencies, hashrates are normally measured in kh/s (divisor = 1e3);
   * for some currencies, hashrates are normally measured in MH/s (divisor = 1e6);
   * for some currencies, hashrates are normally measured in GH/s (divisor = 1e9).
   *
   * @return by default, 1e3
   */
  public function getDivisor() {
    return 1e6;
  }

  /**
   * Get the English name of this algorithm, e.g. "SHA-256" or "Scrypt".
   */
  public function getName() {
    return "SHA-256";
  }

  /**
   * @return the URL of the hash algorithm, or {@code null}
   */
  public function getURL() {
    return "https://en.bitcoin.it/wiki/Block_hashing_algorithm";
  }

}
