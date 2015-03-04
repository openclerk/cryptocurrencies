<?php

namespace Cryptocurrency\Algorithms;

use \Openclerk\Currencies\HashAlgorithm;
use \Openclerk\Currencies\HashAlgorithmInformation;

/**
 * The scrypt algorithm used in Bitcoin, Namecoin etc hashing.
 */
class Scrypt extends HashAlgorithm
    implements HashAlgorithmInformation {

  /**
   * Get the unique 1-32 character algorithm code for this algorithm,
   * e.g. 'sha256' or 'scrypt'. Must be lowercase. This is not visible to users.
   */
  public function getCode() {
    return "scrypt";
  }

  /**
   * For some currencies, hashrates are normally measured in kh/s (divisor = 1e3);
   * for some currencies, hashrates are normally measured in MH/s (divisor = 1e6);
   * for some currencies, hashrates are normally measured in GH/s (divisor = 1e9).
   *
   * @return by default, 1e3
   */
  public function getDivisor() {
    return 1e3;
  }

  /**
   * Get the English name of this algorithm, e.g. "SHA-256" or "Scrypt".
   */
  public function getName() {
    return "scrypt";
  }

  /**
   * @return the URL of the hash algorithm, or {@code null}
   */
  public function getURL() {
    return "https://litecoin.info/Block_hashing_algorithm";
  }

}
