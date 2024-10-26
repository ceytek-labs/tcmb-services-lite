[🇬🇧 Click here for English version](README.md)

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

TCMB (Türkiye Cumhuriyet Merkez Bankası) Services Lite, TCMB'nin sunduğu çeşitli verileri ve API'leri kolayca kullanabilmeniz için tasarlanmıştır. Şu an için döviz kurlarını çekme özelliği sunmaktadır, ancak gelecekte TCMB'nin diğer API'lerini de kapsayacak şekilde genişletilebilir.

## Gereklilikler

- PHP 8.1 veya daha üstü

## Özellikler

- **Döviz Kurları**: Güncel döviz kurlarını TCMB üzerinden çeker.
- **Esnek Yapı**: Verileri nesne veya dizi formatında alabilirsiniz.
- **Genişletilebilirlik**: İleride TCMB'nin diğer API'lerini entegre etmek için uygun altyapı.

## Kurulum

Bu paketi projelerinize eklemek için Composer kullanabilirsiniz:

```bash
composer require ceytek-labs/tcmb-services-lite
```

## Kullanım

Aşağıda paketin temel kullanım örnekleri ve açıklamaları bulunmaktadır.

## API'den Gelen Ham XML Sonucunu Gösterme

```php
use CeytekLabs\Tcmb\TcmbExchangeRates;

// API'den gelen ham XML sonucunu görüntüler
echo TcmbExchangeRates::make()->response();
```

## API'den Gelen Ham JSON Sonucunu Gösterme

```php
use CeytekLabs\Tcmb\TcmbExchangeRates;

// API'den gelen ham XML sonucunu JSON formatına dönüştürür ve görüntüler
echo TcmbExchangeRates::make()->jsonContent();
```

## Döviz Kurlarını Formatlama

API'den gelen verileri nesne veya dizi formatında alabilirsiniz. Nesne formatında camelCase, dizi formatında snake_case kullanılır.

```php
use CeytekLabs\Tcmb\TcmbExchangeRates;
use CeytekLabs\Tcmb\Enums\Format;

// Nesne formatında verileri almak
$exchangeRatesObject = TcmbExchangeRates::make()->format(Format::Object)->content();

// Dizi formatında verileri almak
$exchangeRatesArray = TcmbExchangeRates::make()->format(Format::Array)->content();
```

## Tüm Döviz Kurlarını Alma

```php
use CeytekLabs\Tcmb\TcmbExchangeRates;
use CeytekLabs\Tcmb\Enums\Format;

// Nesne formatında tüm döviz kurlarını almak
$currenciesObject = TcmbExchangeRates::make()->format(Format::Object)->currencies();

// Dizi formatında tüm döviz kurlarını almak
$currenciesArray = TcmbExchangeRates::make()->format(Format::Array)->currencies();
```

## Belirli Bir Dövizi Alma

Belirli bir dövizin verilerini almak için `currency()` metodunu kullanabilirsiniz.

```php
use CeytekLabs\Tcmb\TcmbExchangeRates;
use CeytekLabs\Tcmb\Enums\Format;
use CeytekLabs\Tcmb\Enums\Currency;

// Örneğin, Avustralya Doları (AUD) kurunu almak
$australianDollar = TcmbExchangeRates::make()
    ->format(Format::Object)
    ->currency(Currency::AustralianDollar)
    ->find();
```

## Döviz Bilgilerine Erişmek

Belirli bir dövizin detaylı bilgilerine erişebilirsiniz:

```php
use CeytekLabs\Tcmb\TcmbExchangeRates;
use CeytekLabs\Tcmb\Enums\Format;
use CeytekLabs\Tcmb\Enums\Currency;

// USD dövizinin bilgilerini almak
$exchangeRates = TcmbExchangeRates::make()
    ->format(Format::Object)
    ->currency(Currency::UnitedStatesDollar);

// Döviz kodu
echo $exchangeRates->code(); // "USD"

// Türkçe adı
echo $exchangeRates->turkishName(); // "ABD DOLARI"

// İngilizce adı
echo $exchangeRates->englishName(); // "US DOLLAR"

// Birim miktarı
echo $exchangeRates->unit(); // "1"

// Forex alış kuru (Uluslararası piyasalarda ve dijital işlemlerde geçerli olan alış kuru)
echo $exchangeRates->forexBuying();

// Forex satış kuru (Uluslararası piyasalarda ve dijital işlemlerde geçerli olan satış kuru)
echo $exchangeRates->forexSelling();

// Efektif alış kuru (Nakit döviz işlemlerinde geçerli olan alış kuru)
echo $exchangeRates->banknoteBuying();

// Efektif satış kuru (Nakit döviz işlemlerinde geçerli olan satış kuru)
echo $exchangeRates->banknoteSelling();
```

## Örnek Çıktılar

### Tüm Verilerin Nesne Formatında Gösterimi

```php
use CeytekLabs\Tcmb\TcmbExchangeRates;
use CeytekLabs\Tcmb\Enums\Format;

print_r(TcmbExchangeRates::make()->format(Format::Object)->content());
```

Örnek çıktı:

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
            // Diğer dövizler...
        )
)

```

### Tüm Verilerin Dizi Formatında Gösterimi

```php
use CeytekLabs\Tcmb\TcmbExchangeRates;
use CeytekLabs\Tcmb\Enums\Format;

print_r(TcmbExchangeRates::make()->format(Format::Array)->content());
```

Örnek çıktı:

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
            // Diğer dövizler...
        )
)
```

## Desteklenen Para Birimleri

Paket aşağıdaki para birimlerini desteklemektedir:

- 🇺🇸 **USD**: ABD Doları
- 🇦🇺 **AUD**: Avustralya Doları
- 🇩🇰 **DKK**: Danimarka Kronu
- 🇪🇺 **EUR**: Euro
- 🇬🇧 **GBP**: İngiliz Sterlini
- 🇨🇭 **CHF**: İsviçre Frangı
- 🇸🇪 **SEK**: İsveç Kronu
- 🇨🇦 **CAD**: Kanada Doları
- 🇰🇼 **KWD**: Kuveyt Dinarı
- 🇳🇴 **NOK**: Norveç Kronu
- 🇸🇦 **SAR**: Suudi Arabistan Riyali
- 🇯🇵 **JPY**: Japon Yeni
- 🇧🇬 **BGN**: Bulgar Levası
- 🇷🇴 **RON**: Rumen Leyi
- 🇷🇺 **RUB**: Rus Rublesi
- 🇮🇷 **IRR**: İran Riyali
- 🇨🇳 **CNY**: Çin Yuanı
- 🇵🇰 **PKR**: Pakistan Rupisi
- 🇶🇦 **QAR**: Katar Riyali
- 🇰🇷 **KRW**: Güney Kore Wonu
- 🇦🇿 **AZN**: Azerbaycan Manatı
- 🇦🇪 **AED**: Birleşik Arap Emirlikleri Dirhemi

## Hata Ayıklama

API'den gelen yanıt geçersiz ise veya bir hata oluşursa, bir `Exception` fırlatılır.
XML formatı geçersiz olduğunda, şu hatayı alırsınız: `Invalid XML format. Please check TcmbExchangeRates::make()->getResponse()`

## Gelecek Planları

Bu paket, TCMB'nin sağladığı diğer veri ve hizmetleri de kapsayacak şekilde genişletilebilir. Örneğin:

- **Faiz Oranları:** TCMB'nin yayınladığı faiz oranlarını almak.
- **Enflasyon Verileri:** Güncel enflasyon verilerine erişim.
- **Diğer Finansal Veriler:** TCMB'nin sunduğu diğer istatistik ve raporları entegre etmek.

## Katkıda Bulunma

Katkıda bulunmak isterseniz, lütfen bir pull request gönderin veya bir sorun bildirin.

## Lisans

Bu proje MIT Lisansı ile lisanslanmıştır.