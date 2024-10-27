[🇹🇷 Türkçe sürüm için buraya tıklayın](README.tr.md)

<p align="center">
    <img src="https://raw.githubusercontent.com/ceytek-labs/tcmb-services-lite/refs/heads/1.x/art/banner.png" width="400" alt="54grad.de Services Lite">
    <p align="center">
        <a href="https://packagist.org/packages/ceytek-labs/tcmb-services-lite"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/ceytek-labs/tcmb-services-lite"></a>
        <a href="https://packagist.org/packages/ceytek-labs/tcmb-services-lite"><img alt="Latest Version" src="https://img.shields.io/packagist/v/ceytek-labs/tcmb-services-lite"></a>
        <a href="https://packagist.org/packages/ceytek-labs/tcmb-services-lite"><img alt="Size" src="https://img.shields.io/github/repo-size/ceytek-labs/tcmb-services-lite"></a>
        <a href="https://packagist.org/packages/ceytek-labs/tcmb-services-lite"><img alt="License" src="https://img.shields.io/packagist/l/ceytek-labs/tcmb-services-lite"></a>
    </p>
</p>

------

# TCMB Services Lite

The TCMB (Central Bank of the Republic of Turkey) Services Lite is designed to help you easily utilize various data and APIs provided by the TCMB. Currently, it offers the feature of fetching exchange rates, but it can be expanded in the future to include other APIs from the TCMB.

> **Disclaimer:** This package is not an official product of Central Bank of the Republic of Türkiye (Türkiye Cumhuriyet Merkez Bankası). The developers accept no responsibility for any issues, discrepancies, or damages that may arise from its use.

## Requirements

- PHP 8.1 or higher

## Installation

You can add this package to your projects using Composer:

```bash
composer require ceytek-labs/tcmb-services-lite
```

## Services

- [TCMB Exchange Rates](#tcmb-exchange-rates)
    - [Display Raw XML Result from the API](#display-raw-xml-result-from-the-api)
    - [Display Raw JSON Result from the API](#display-raw-json-result-from-the-api)
    - [Formatting Exchange Rates](#formatting-exchange-rates)
    - [Getting All Exchange Rates](#getting-all-exchange-rates)
    - [Getting a Specific Currency](#getting-a-specific-currency)
    - [Accessing Currency Information](#accessing-currency-information)
    - [Displaying All Data in Object Format](#displaying-all-data-in-object-format)
    - [Displaying All Data in Array Format](#displaying-all-data-in-array-format)
    - [Supported Currencies](#supported-currencies)

## TCMB Exchange Rates

The **TCMB Exchange Rates** retrieves daily exchange rates from the Central Bank of Turkey, providing easy access to various currency information.

### Example Usage

Here are a few examples of how you can use the **TCMB Exchange Rates** class in your PHP projects

**[⬆ Back to services](#services)**

#### Display Raw XML Result from the API

```php
use CeytekLabs\TcmbServicesLite\TcmbExchangeRates;

// Displays the raw XML result from the API
echo TcmbExchangeRates::make()->response();
```

**[⬆ Back to services](#services)**

#### Display Raw JSON Result from the API

```php
use CeytekLabs\TcmbServicesLite\TcmbExchangeRates;

// Converts the raw XML result from the API to JSON and displays it
echo TcmbExchangeRates::make()->jsonContent();
```

**[⬆ Back to services](#services)**

#### Formatting Exchange Rates

You can receive data from the API in either object or array format. CamelCase is used in object format, and snake_case is used in array format.

```php
use CeytekLabs\TcmbServicesLite\TcmbExchangeRates;
use CeytekLabs\TcmbServicesLite\Enums\Format;

// Getting data in object format
$exchangeRatesObject = TcmbExchangeRates::make()->format(Format::Object)->content();

// Getting data in array format
$exchangeRatesArray = TcmbExchangeRates::make()->format(Format::Array)->content();
```

**[⬆ Back to services](#services)**

#### Getting All Exchange Rates

```php
use CeytekLabs\TcmbServicesLite\TcmbExchangeRates;
use CeytekLabs\TcmbServicesLite\Enums\Format;

// Getting all exchange rates in object format
$currenciesObject = TcmbExchangeRates::make()->format(Format::Object)->currencies();

// Getting all exchange rates in array format
$currenciesArray = TcmbExchangeRates::make()->format(Format::Array)->currencies();
```

**[⬆ Back to services](#services)**

#### Getting a Specific Currency

You can use the `currency()` method to get data for a specific currency.

```php
use CeytekLabs\TcmbServicesLite\TcmbExchangeRates;
use CeytekLabs\TcmbServicesLite\Enums\Format;
use CeytekLabs\TcmbServicesLite\Enums\Currency;

// For example, getting the Australian Dollar (AUD) rate
$australianDollar = TcmbExchangeRates::make()
    ->format(Format::Object)
    ->currency(Currency::AustralianDollar)
    ->find();
```

**[⬆ Back to services](#services)**

#### Accessing Currency Information

You can access detailed information of a specific currency:

```php
use CeytekLabs\TcmbServicesLite\TcmbExchangeRates;
use CeytekLabs\TcmbServicesLite\Enums\Format;
use CeytekLabs\TcmbServicesLite\Enums\Currency;

// Getting information for the USD currency
$exchangeRates = TcmbExchangeRates::make()
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

**[⬆ Back to services](#services)**

#### Displaying All Data in Object Format

```php
use CeytekLabs\TcmbServicesLite\TcmbExchangeRates;
use CeytekLabs\TcmbServicesLite\Enums\Format;

print_r(TcmbExchangeRates::make()->format(Format::Object)->content());
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

**[⬆ Back to services](#services)**

#### Displaying All Data in Array Format

```php
use CeytekLabs\TcmbServicesLite\TcmbExchangeRates;
use CeytekLabs\TcmbServicesLite\Enums\Format;

print_r(TcmbExchangeRates::make()->format(Format::Array)->content());
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

**[⬆ Back to services](#services)**

#### Supported Currencies

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
- If the XML format is invalid, you will receive the following error: `Invalid XML format. Please check TcmbExchangeRates::make()->getResponse()`

## Future Plans

This package can be expanded to include other data and services provided by the TCMB, such as:

- **Interest Rates:** Fetching interest rates published by the TCMB.
- **Inflation Data:** Access to current inflation data.
- **Other Financial Data:** Integrating other statistics and reports provided by the TCMB.

## Contributing

If you'd like to contribute, please send a pull request or report an issue.

## License

This project is licensed under the MIT License.