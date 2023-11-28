# sberbank_ecom_client
PHP client for Sberbank ( https://ecommerce.sberbank.ru )

[![Version](http://poser.pugx.org/rusadrako/sberbank_ecom_client/version)](https://packagist.org/packages/rusadrako/sberbank_ecom_client)
[![Total Downloads](http://poser.pugx.org/rusadrako/sberbank_ecom_client/downloads)](https://packagist.org/packages/rusadrako/sberbank_ecom_client/stats)
[![License](http://poser.pugx.org/rusadrako/sberbank_ecom_client/license)](./LICENSE)


## Документация
- [API платёжного шлюза Сбербанка (1.0.4)](https://ecomtest.sberbank.ru/doc)


## Установка (composer)
```sh
composer require 'rusadrako/sberbank_ecom_client'
```


## Установка (manual)
- Скачать и распоковать библиотеку.
- Добавить в код инструкцию:
```php
require_once('/sberbank_ecom_client/src/autoload.php')
```


## Класс Client
Базовый класс Клиента.
```php
use RusaDrako\sberbank_ecom_client\Client;

$options = [
    'userName' => 'yourLogin',
    'password' => 'yourPassword',
    'api_host' => Client::API_HOST,
];
$client = new Client($options);
```
По умолчанию клиент использует тестовый `api_host` => `Client::API_HOST_TEST` ( https://ecomtest.sberbank.ru/ )

Полный набор свойств:
```php
use RusaDrako\sberbank_ecom_client\Client;
use RusaDrako\sberbank_ecom_client\Currency;
use RusaDrako\sberbank_ecom_client\Language;

$options = [
    'userName' => 'yourLogin', // Логин Клиента
    'password' => 'yourPassword', // Пароль Клиента
    'api_host' => Client::API_HOST_TEST, // Хост
    'currency' => Currency::RUB, // Валюта
    'language' => Language::RUS, // Язык
    'timeout' => 10, //Время ожидания ответа
    'datafile' => __DIR__ . '/sberbank_ecom_1.0.4.json', // Местоположение файла с настройками
];
```

#### Метод action()
Формирует и выполняет действие. Возвращает объект `Response` с результатом запроса.
```php
$response = $client->action('register.do', [
                                               'orderNumber' => 'тест-1',
                                               'amount' => 10000,
                                               'returnUrl' => 'http://www.test.test/',
                                           ]);
```
Является краткой формой для:
```php
/** @var Action $action */
$action = $client->getAction('register.do');

$action->orderNumber = 'тест-1';
$action->amount = 10000;
$action->returnUrl = 'https://www.mealty.ru/';

/** @var Response $response */
$response = $action->execute();
```

#### Метод getAction()
Возвращает объект `Action` с настройками указанного действия.
```php
$action = $client->getAction('register.do');
```


## Класс Action
Объект действия с его настройками.

#### Метод execute()
Выполняет запрос действия. Возвращает объект `Response` с результатом запроса.
```php
$response = $action->execute();
```

#### Метод getActionName()
Возвращает имя действия.
```php
$string = $action->getActionName();
```

#### Метод getOptionsJSON()
Возвращает JSON запроса действия.
```php
$json = $action->getOptionsJSON();
```


## Класс Response
Объект результата запроса.
```php
$response->errorCode;
$response->errorMessage;
...
```

#### Метод getJSON()
Возвращает результат запроса в формате JSON.
```php
$json = $response->getJSON();
```

#### Метод getArray()
Возвращает результат запроса в формате Array.
```php
$array = $response->getArray();
```


## Класс Currency
Объект с кодами валют в соответствующем формате.
```php
use RusaDrako\sberbank_ecom_client\Currency;

$currency_code = Currency::RUB;
```

## Класс Language
Объект с кодами языков в соответствующем формате.
```php
use RusaDrako\sberbank_ecom_client\Language;

$currency_code = Language::RUS;
```


## License
Copyright (c) Petukhov Leonid. Distributed under the MIT.