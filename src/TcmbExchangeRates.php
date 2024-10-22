<?php

namespace CeytekLabs\Tcmb;

use CeytekLabs\Tcmb\Enums\Currency;
use CeytekLabs\Tcmb\Enums\Format;

class TcmbExchangeRates
{
    private string $apiUrl = 'https://www.tcmb.gov.tr/kurlar/today.xml';

    private string $response;

    private string|null $jsonContent = null;

    private \stdClass|array|null $content = null;

    private Currency $currency;

    public static function make(): self
    {
        $instance = new self;
        
        try {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $instance->apiUrl,
                CURLOPT_RETURNTRANSFER => true,
            ]);

            $instance->response = curl_exec($curl);

            if (curl_errno($curl)) {
                throw new \Exception('Error: '.curl_error($curl));
            }

            curl_close($curl);

            $xml = simplexml_load_string($instance->response);

            if ($xml === false) {
                throw new \Exception('Invalid XML format. Please check TcmbExchangeRates::make()->getResponse()');
            }
    
            $instance->jsonContent = json_encode($xml);
        } catch (\Exception $exception) {
            throw new \Exception('Failed to fetch data from TCMB: ' . $exception->getMessage());
        }

        return $instance;
    }

    public function response(): string
    {
        return $this->response;
    }

    public function jsonContent(): string
    {
        return $this->jsonContent;
    }

    public function format(Format $format): self
    {
        $xml = simplexml_load_string($this->response);

        if ($xml === false) {
            throw new \Exception('Invalid XML format. Please check TcmbExchangeRates::make()->getResponse()');
        }

        $arrayContent = json_decode($this->jsonContent, true);

        $content = [];

        foreach ($arrayContent as $key => $value) {
            if ($key === '@attributes') {
                $content['attributes']['date'] = \DateTime::createFromFormat('m/d/Y', $value['Date'])->format('Y-m-d 15:30');
            
                if ($format === Format::Object) {
                    $content['attributes']['bulletinNumber'] = $value['Bulten_No'];
                }
    
                if ($format === Format::Array) {
                    $content['attributes']['bulletin_number'] = $value['Bulten_No'];
                }
            }

            if ($key === 'Currency') {
                foreach ($value as $currency) {
                    $code = $currency['@attributes']['CurrencyCode'];

                    $content['currencies'][$code]['code'] = $code;
    
                    $content['currencies'][$code]['name'] = [
                        'tr' => $currency['Isim'],
                        'en' => $currency['CurrencyName'],
                    ];
    
                    $content['currencies'][$code]['unit'] = $currency['Unit'];

                    $content['currencies'][$code]['forex'] = [
                        'buying' => !empty($currency['ForexBuying']) ? $currency['ForexBuying'] : null,
                        'selling' => !empty($currency['ForexSelling']) ? $currency['ForexSelling'] : null,
                    ];

                    $content['currencies'][$code]['banknote'] = [
                        'buying' => !empty($currency['BanknoteBuying']) ? $currency['BanknoteBuying'] : null,
                        'selling' => !empty($currency['BanknoteSelling']) ? $currency['BanknoteSelling'] : null,
                    ];
                }
            }
        }

        $this->content = match ($format) {
            Format::Object => json_decode(json_encode($content)),
            Format::Array => $content,
        };

        return $this;
    }

    public function content(): \stdClass|array|null
    {
        return $this->content;
    }

    public function currencies(): \stdClass|array|null
    {
        if ($this->content instanceof \stdClass) {
            return $this->content->currencies ?? null;
        }

        if (is_array($this->content)) {
            return $this->content['currencies'] ?? null;
        }

        return null;
    }

    public function currency(Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function find(): \stdClass|array|null
    {
        $currencies = $this->currencies();

        if (is_object($currencies)) {
            return $currencies->{$this->currency->value};
        }

        if (is_array($currencies)) {
            return $currencies[$this->currency->value];
        }

        return null;
    }

    public function code(): string
    {
        $currency = $this->find();

        if (is_object($currency)) {
            return $currency->code;
        }

        if (is_array($currency)) {
            return $currency['code'];
        }

        return null;
    }

    public function turkishName(): string
    {
        $currency = $this->find();

        if (is_object($currency)) {
            return $currency->name->tr;
        }

        if (is_array($currency)) {
            return $currency['name']['tr'];
        }

        return null;
    }

    public function englishName(): string
    {
        $currency = $this->find();

        if (is_object($currency)) {
            return $currency->name->en;
        }

        if (is_array($currency)) {
            return $currency['name']['en'];
        }

        return null;
    }

    public function unit(): string
    {
        $currency = $this->find();

        if (is_object($currency)) {
            return $currency->unit;
        }

        if (is_array($currency)) {
            return $currency['unit'];
        }

        return null;
    }

    public function forexBuying(): string|null
    {
        $currency = $this->find();

        if (is_object($currency)) {
            return $currency->forex->buying;
        }

        if (is_array($currency)) {
            return $currency['forex']['buying'];
        }

        return null;
    }

    public function forexSelling(): string|null
    {
        $currency = $this->find();

        if (is_object($currency)) {
            return $currency->forex->selling;
        }

        if (is_array($currency)) {
            return $currency['forex']['selling'];
        }

        return null;
    }

    public function banknoteBuying(): string|null
    {
        $currency = $this->find();

        if (is_object($currency)) {
            return $currency->banknote->buying;
        }

        if (is_array($currency)) {
            return $currency['banknote']['buying'];
        }

        return null;
    }

    public function banknoteSelling(): string|null
    {
        $currency = $this->find();

        if (is_object($currency)) {
            return $currency->banknote->selling;
        }

        if (is_array($currency)) {
            return $currency['banknote']['selling'];
        }

        return null;
    }
}