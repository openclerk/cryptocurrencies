openclerk/cryptocurrencies
==========================

A library for accessing balances, block counts and difficulties of
common cryptocurrencies, used by [Openclerk](http://openclerk.org)
and live on [CryptFolio](https://cryptfolio.com).

This extends on the abstract currency definitions provided by
[openclerk/currencies](https://github.com/openclerk/currencies).

## Installing

Include `openclerk/cryptocurrencies` as a requirement in your project `composer.json`,
and run `composer update` to install it into your project:

```json
{
  "require": {
    "openclerk/cryptocurrencies": "dev-master"
  }
}
```

* [Currencies supported](https://github.com/openclerk/cryptocurrencies/tree/master/src)
* [Services supported](https://github.com/openclerk/cryptocurrencies/tree/master/src/Services)

## Using

Get the balance for a certain address:

```php
use \Monolog\Logger;

$logger = new Logger("log");

$currency = new \Cryptocurrencies\Dogecoin();
$balance = $currency->getBalance("D64vbPp9TvqQ67xc6we5GnEtcKqiTXfp1S", $logger);
```

Get the balance for a certain address with a number of confirmations:

```php
$currency = new \Cryptocurrencies\Bitcoin();
$balance = $currency->getBalanceWithConfirmations("17eTMdqaFRSttfBYB9chKEzHubECZPTS6p", 6, $logger);
```

Get the current difficulty of a given cryptocurrency:

```php
$currency = new \Cryptocurrencies\Litecoin();
$balance = $currency->getDifficulty($logger);
```

Check whether a given address is valid:

```php
$currency = new \Cryptocurrencies\Bitcoin();
return $currency->isValid("17eTMdqaFRSttfBYB9chKEzHubECZPTS6p");
```

## Tests

Each cryptocurrency comes with a suite of tests to check each associated service.

```
composer install
vendor/bin/phpunit
```

To run the tests for a single currency:

```
vendor/bin/phpunit --bootstrap "vendor/autoload.php" test/DogecoinTest
```

## Assets

Assets for each cryptocurrency, for example icons associated with the currency and
associated services, are provided in `css/` and `images/`.

These can be included into your project with [asset-discovery](https://github.com/soundasleep/asset-discovery)
and mixins are provided, for example:

```scss
@each $code in $currency-codes {
  .currency_name.currency_#{$code}, .currency_name_#{$code} {
    padding-left: 20px;
    @include currency-label-background($code);
    background-position: 0 0;
    background-repeat: no-repeat;
    background-size: 16px 16px;
  }
}
```

## Donate

[Donations are appreciated](https://code.google.com/p/openclerk/wiki/Donating).

## Contributing

Pull requests that contribute new currencies, services or APIs are welcome.

For new currencies, make sure that you also provide an associated
`CurrencyTest` so that the currency is automatically testable.

## TODO

1. Generate README list of currencies/services automatically
1. Provide 32x32 icons for each cryptocurrency
1. Link to live APIs on CryptFolio
1. CI build server and link to test results
