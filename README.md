# sberbank_ecom_client
PHP client for Sberbank ( https://ecommerce.sberbank.ru )

[![Build Status](https://app.travis-ci.com/rusadrako/sberbank_ecom_client.svg?branch=master)](https://app.travis-ci.com/github/voronkovich/sberbank-acquiring-client)
[![Latest Stable Version](https://poser.pugx.org/rusadrako/sberbank_ecom_client/v/stable)](https://packagist.org/packages/voronkovich/sberbank-acquiring-client)
[![Total Downloads](https://poser.pugx.org/rusadrako/sberbank_ecom_client/downloads)](https://packagist.org/packages/voronkovich/sberbank-acquiring-client/stats)
[![License](https://poser.pugx.org/rusadrako/sberbank_ecom_client/license)](./LICENSE)

## Документация
- [API платёжного шлюза Сбербанка (1.0.4)](https://ecomtest.sberbank.ru/doc)

## Installation

```sh
composer require 'rusadrako/sberbank_ecom_client'
```

### Client

```php
use RusaDrako\sberbank_ecom_client\Client;
$options = [
    'userName' => '...',
    'password' => '...',
    'api_host' => Client::API_HOST,
];
$client = new Client($options);
```

### Currency

Объект с кодами валют в соответствующем формате.

```php
use RusaDrako\sberbank_ecom_client\Currency;
$currency_code = Currency::RUB;
```

### License

Copyright (c) Petukhov Leonid. Distributed under the MIT.