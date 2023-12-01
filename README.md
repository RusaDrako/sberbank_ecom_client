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
    'datafile' => __DIR__ . '/sberbank_ecom_1.0.4.json', // Местоположение файла со спецификацией OpenAPI
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

#### Метод getOptionsJSONWithNotAuth()
Возвращает JSON запроса действия без настроек аутентификации.
```php
$json = $action->getOptionsJSONWithNotAuth();
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


## Класс ClientExpansion
Расширенние функционала класса Client для совместимости с Voronkovich\sberbank-acquiring-client (v2.8)

```php
/** Register a new order. */
public function registerOrder($orderNumber, int $amount, string $returnUrl, array $data = []) { ... }
/** Register a new order using a 2-step payment process. */
public function registerOrderPreAuth($orderNumber, int $amount, string $returnUrl, array $data = []) { ... }
/** Register a new credit order. */
public function registerCreditOrder($orderNumber, int $amount, string $returnUrl, array $data = []) { ... }
/** Register a new credit order using a 2-step payment process. */
public function registerCreditOrderPreAuth($orderNumber, int $amount, string $returnUrl, array $data = []) { ... }
/** Deposit an existing order. */
public function deposit($orderId, int $amount, array $data = []) { ... }
/** Reverse an existing order. */
public function reverseOrder($orderId, array $data = []) { ... }
/** Refund an existing order. */
public function refundOrder($orderId, int $amount, array $data = []) { ... }
/** Get an existing order's status by Sberbank's gateway identifier. */
public function getOrderStatus($orderId, array $data = []) { ... }
/** Get an existing order's status by own identifier. */
public function getOrderStatusByOwnId($orderId, array $data = []) { ... }
/** Verify card enrollment in the 3DS. */
public function verifyEnrollment(string $pan, array $data = []) { "не реализован"; }
/** Update an SSL card list. */
public function updateSSLCardList($orderId, array $data = []) { "не реализован"; }
/** Get last orders for merchants. */
public function getLastOrdersForMerchants(\DateTimeInterface $from, \DateTimeInterface $to = null, array $data = []) { "не реализован"; }
/** Payment order binding. $ip - new */
public function paymentOrderBinding($mdOrder, $bindingId, string $ip, array $data = []) { ... }
/** Activate a binding. */
public function bindCard($bindingId, array $data = []) { ... }
/** Deactivate a binding. */
public function unBindCard($bindingId, array $data = []) { ... }
/** Extend a binding. */
public function extendBinding($bindingId, \DateTimeInterface $newExpiry, array $data = []) { "не реализован"; }
/** Get bindings. */
public function getBindings($clientId, array $data = []) { ... }
/** Get a receipt status. $receiptId - new */
public function getReceiptStatus(string $receiptId, array $data) { ... }
/** Pay with Apple Pay. */
public function payWithApplePay($orderNumber, string $merchant, string $paymentToken, array $data = []) { "не реализован"; }
/** Pay with Google Pay. */
public function payWithGooglePay($orderNumber, string $merchant, string $paymentToken, array $data = []) { "не реализован"; }
/** Pay with Samsung Pay. */
public function payWithSamsungPay($orderNumber, string $merchant, string $paymentToken, array $data = []) { "не реализован"; }
/** Get QR code for payment through SBP. */
public function getSbpDynamicQr($orderId, array $data = []) { "не реализован"; }
/** Get QR code status. */
public function getSbpQrStatus($orderId, string $qrId, array $data = []) { "не реализован"; }
```


## License
Copyright (c) Petukhov Leonid. Distributed under the MIT.