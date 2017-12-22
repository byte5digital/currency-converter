# Currency Converter
**Laravel wrapper for [fixer.io](https://fixer.io)**

[![Travis](https://img.shields.io/travis/byte5digital/currency-converter.svg?style=flat-square)]()

## Install
`composer require byte5digital/currency-converter`

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

##Changelog
Please see CHANGELOG for more information what has changed recently.

##Contributing
Please see CONTRIBUTING for details.

##Security
If you discover any security-related issues, please email [kkoenig@byte5.de](mailto:kkoenig@byte5.de) instead of using the issue tracker.

## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.