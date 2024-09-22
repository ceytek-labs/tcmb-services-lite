[🇹🇷 Türkçe sürüm için buraya tıklayın](README.tr.md)

# TCMB PHP Package

The TCMB (Central Bank of the Republic of Turkey) PHP package is designed to help you easily utilize various data and APIs provided by the TCMB. Currently, it offers the feature of fetching exchange rates, but it can be expanded in the future to include other APIs from the TCMB.

## Features

- **Exchange Rates**: Fetches current exchange rates from the TCMB.
- **Flexible Structure**: You can receive data in object or array format.
- **Scalability**: Built with an infrastructure suitable for integrating other TCMB APIs in the future.

## Installation

You can add this package to your projects using Composer:

```bash
composer require ceytek-labs/tcmb
```

## Usage

Below are basic usage examples and explanations of the package.

## Display Raw XML Result from the API

```php
use CeytekLabs\Tcmb\ExchangeRates;

// Displays the raw XML result from the API
echo ExchangeRates::make()->response();
```

## Display Raw JSON Result from the API

```php
use CeytekLabs\Tcmb\ExchangeRates;

// Converts the raw XML result from the API to JSON and displays it
echo ExchangeRates::make()->jsonContent();
```

## Formatting Exchange Rates

You can receive data from the API in either object or array format. CamelCase is used in object format, and snake_case is used in array format.

```php
use CeytekLabs\Tcmb\ExchangeRates;
use CeytekLabs\Tcmb\Enums\Format;

// Getting data in object format
$exchangeRatesObject = ExchangeRates::make()->format(Format::Object)->content();

// Getting data in array format
$exchangeRatesArray = ExchangeRates::make()->format(Format::Array)->content();
```

## Getting All Exchange Rates

```php
use CeytekLabs\Tcmb\ExchangeRates;
use CeytekLabs\Tcmb\Enums\Format;

// Getting all exchange rates in object format
$currenciesObject = ExchangeRates::make()->format(Format::Object)->currencies();

// Getting all exchange rates in array format
$currenciesArray = ExchangeRates::make()->format(Format::Array)->currencies();
```

## Getting a Specific Currency

You can use the `currency()` method to get data for a specific currency.

```php
use CeytekLabs\Tcmb\ExchangeRates;
use CeytekLabs\Tcmb\Enums\Format;
use CeytekLabs\Tcmb\Enums\Currency;

// For example, getting the Australian Dollar (AUD) rate
$australianDollar = ExchangeRates::make()
    ->format(Format::Object)
    ->currency(Currency::AustralianDollar)
    ->first();
```

## Accessing Currency Information

You can access detailed information of a specific currency:

```php
use CeytekLabs\Tcmb\ExchangeRates;
use CeytekLabs\Tcmb\Enums\Currency;

// Getting information for the USD currency
$exchangeRates = ExchangeRates::make()
    ->format(Format::Object)
    ->currency(Currency::UnitedStatesDollar);

// Currency code
echo $exchangeRates->code(); // "USD"

// Turkish name
echo $exchangeRates->turkishName(); // "ABD DOLARI"

// English name
echo $exchangeRates->englishName(); // "US DOLLAR"

// Unit amount
echo $exchangeRates->unit(); // "1"

// Forex buying rate (The buying rate valid in international markets and digital transactions)
echo $exchangeRates->forexBuying();

// Forex selling rate (The selling rate valid in international markets and digital transactions)
echo $exchangeRates->forexSelling();

// Banknote buying rate (The buying rate valid in cash currency transactions)
echo $exchangeRates->banknoteBuying();

// Banknote selling rate (The selling rate valid in cash currency transactions)
echo $exchangeRates->banknoteSelling();
```

## Example Outputs

### Displaying All Data in Object Format

```php
use CeytekLabs\Tcmb\ExchangeRates;
use CeytekLabs\Tcmb\Enums\Format;

print_r(ExchangeRates::make()->format(Format::Object)->content());
```

Sample output:

```php
stdClass Object
(
    [attributes] => stdClass Object
        (
            [date] => "2024-09-20 15:30"
            [bulletinNumber] => "2024/178"
        )

    [currencies] => stdClass Object
        (
            [USD] => stdClass Object
                (
                    [code] => "USD"
                    [name] => stdClass Object
                        (
                            [tr] => "ABD DOLARI"
                            [en] => "US DOLLAR"
                        )
                    [unit] => "1"
                    [forex] => stdClass Object
                        (
                            [buying] => "33.9531"
                            [selling] => "34.0142"
                        )
                    [banknote] => stdClass Object
                        (
                            [buying] => "33.9293"
                            [selling] => "34.0652"
                        )
                )
            // Other currencies...
        )
)

```

### Displaying All Data in Array Format

```php
use CeytekLabs\Tcmb\ExchangeRates;
use CeytekLabs\Tcmb\Enums\Format;

print_r(ExchangeRates::make()->format(Format::Array)->content());
```

Sample output:

```php
Array
(
    [attributes] => Array
        (
            [date] => "2024-09-20 15:30"
            [bulletin_number] => "2024/178"
        )

    [currencies] => Array
        (
            [USD] => Array
                (
                    [code] => "USD"
                    [name] => Array
                        (
                            [tr] => "ABD DOLARI"
                            [en] => "US DOLLAR"
                        )
                    [unit] => "1"
                    [forex] => Array
                        (
                            [buying] => "33.9531"
                            [selling] => "34.0142"
                        )
                    [banknote] => Array
                        (
                            [buying] => "33.9293"
                            [selling] => "34.0652"
                        )
                )
            // Other currencies...
        )
)
```

## Supported Currencies

The package supports the following currencies:

- 🇺🇸 **USD**: United States Dollar
- 🇦🇺 **AUD**: Australian Dollar
- 🇩🇰 **DKK**: Danish Krone
- 🇪🇺 **EUR**: Euro
- 🇬🇧 **GBP**: British Pound
- 🇨🇭 **CHF**: Swiss Franc
- 🇸🇪 **SEK**: Swedish Krona
- 🇨🇦 **CAD**: Canadian Dollar
- 🇰🇼 **KWD**: Kuwaiti Dinar
- 🇳🇴 **NOK**: Norwegian Krone
- 🇸🇦 **SAR**: Saudi Riyal
- 🇯🇵 **JPY**: Japanese Yen
- 🇧🇬 **BGN**: Bulgarian Lev
- 🇷🇴 **RON**: Romanian Leu
- 🇷🇺 **RUB**: Russian Ruble
- 🇮🇷 **IRR**: Iranian Rial
- 🇨🇳 **CNY**: Chinese Yuan
- 🇵🇰 **PKR**: Pakistani Rupee
- 🇶🇦 **QAR**: Qatari Riyal
- 🇰🇷 **KRW**: South Korean Won
- 🇦🇿 **AZN**: Azerbaijani Manat
- 🇦🇪 **AED**: United Arab Emirates Dirham

## Debugging

- If the response from the API is invalid or an error occurs, an `Exception` will be thrown.
- If the XML format is invalid, you will receive the following error: `Invalid XML format. Please check ExchangeRates::make()->getResponse()`

## Future Plans

This package can be expanded to include other data and services provided by the TCMB, such as:

- **Interest Rates:** Fetching interest rates published by the TCMB.
- **Inflation Data:** Access to current inflation data.
- **Other Financial Data:** Integrating other statistics and reports provided by the TCMB.

## Contributing

If you'd like to contribute, please send a pull request or report an issue.

## License

This project is licensed under the MIT License.