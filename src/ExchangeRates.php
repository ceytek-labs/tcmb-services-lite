<?php

namespace CeytekLabs\Tcmb;

use CeytekLabs\Tcmb\Enums\CurrencyCode;
use CeytekLabs\Tcmb\Enums\FormatType;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ExchangeRates
{
    private string $apiUrl = 'https://www.tcmb.gov.tr/kurlar/today.xml';

    private string $response;

    private \stdClass|array|null $content = null;

    public static function make(): self
    {
        $instance = new self;

        $client = new Client();
        
        try {
            $instance->response = $client->request('GET', $instance->apiUrl)->getBody()->getContents();
        } catch (RequestException $exception) {
            throw new \Exception('Failed to fetch data from TCMB: ' . $exception->getMessage());
        }

        return $instance;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function format(FormatType $formatType): self
    {
        $xml = simplexml_load_string($this->response);

        if ($xml === false) {
            throw new \Exception('Invalid XML format. Please check ExchangeRates::make()->getResponse()');
        }

        $this->content = match ($formatType) {
            FormatType::Object => json_decode(json_encode($xml)),
            FormatType::Array => json_decode(json_encode($xml), true),
        };

        return $this;
    }

    public function getContent(): \stdClass|array|null
    {
        return $this->content;
    }

    public function getCurrencies(): \stdClass|array|null
    {
        if ($this->content instanceof \stdClass) {
            return (object) $this->content->Currency ?? null;
        }

        if (is_array($this->content)) {
            return $this->content['Currency'] ?? null;
        }

        return null;
    }

    public function getCurrency(CurrencyCode $currencyCode): \stdClass|array|null
    {
        $currencies = $this->getCurrencies();

        if (is_object($currencies)) {
            foreach ($currencies as $currency) {
                if ($currency->{'@attributes'}->CurrencyCode === $currencyCode->value) {
                    return $currency;
                }
            }
        }

        if (is_array($currencies)) {
            foreach ($currencies as $currency) {
                if ($currency['@attributes']['CurrencyCode'] === $currencyCode->value) {
                    return $currency;
                }
            }
        }

        return null;
    }

    public function getCurrencyForexBuying(CurrencyCode $currencyCode): string|null
    {
        $currency = $this->getCurrency($currencyCode);

        if (is_object($currency)) {
            return $currency->ForexBuying;
        }

        if (is_array($currency)) {
            return $currency['ForexBuying'];
        }

        return null;
    }

    public function getCurrencyForexSelling(CurrencyCode $currencyCode): string|null
    {
        $currency = $this->getCurrency($currencyCode);

        if (is_object($currency)) {
            return $currency->ForexSelling;
        }

        if (is_array($currency)) {
            return $currency['ForexSelling'];
        }

        return null;
    }

    public function getCurrencyBanknoteBuying(CurrencyCode $currencyCode): string|null
    {
        $currency = $this->getCurrency($currencyCode);

        if (is_object($currency)) {
            return $currency->BanknoteBuying;
        }

        if (is_array($currency)) {
            return $currency['BanknoteBuying'];
        }

        return null;
    }

    public function getCurrencyBanknoteSelling(CurrencyCode $currencyCode): string|null
    {
        $currency = $this->getCurrency($currencyCode);

        if (is_object($currency)) {
            return $currency->BanknoteSelling;
        }

        if (is_array($currency)) {
            return $currency['BanknoteSelling'];
        }

        return null;
    }
}