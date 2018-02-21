# A Laravel wrapper for [fixer.io](https://fixer.io)

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/byte5digital/currency-converter.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/byte5digital/currency-converter.svg?style=flat-square)](https://packagist.org/packages/byte5digital/currency-converter)

## Install
#### Laravel Version 5.6+
`composer require byte5digital/currency-converter`

#### Laravel Version 5.5
`composer require byte5digital/currency-converter:v1.1`

*optional*
`php artisan vendor:publish --provider="Byte5\CurrencyConverter\CurrencyConverterServiceProvider"`

## Usage
```
// Converting currencies
Currency::convert(100, 'EUR')->into('USD');

// get currency rates
Currency::getLatestRates();

// get rates for different base (default: EUR)
Currency::setBase('USD')->getLatestRates();

// get specific currency rates
Currency::getLatestRates(['USD', 'GBP']);
Currency::getLatestRates('USD');

// get historical currency rates
Currency::getHistoricalRates('2000-01-03');
Currency::getHistoricalRates(Carbon::yesterday());
Currency::getHistoricalRates('2000-01-03', ['USD', 'GBP']);
```

## Testing
Run the tests with:

``` bash
vendor/bin/phpunit
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security
If you discover any security-related issues, please email kkoenig@byte5.de instead of using the issue tracker.

## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.