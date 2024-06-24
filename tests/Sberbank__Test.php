<?php

namespace RusaDrako\sberbank_ecom_client\Tests;

use PHPUnit\Framework\TestCase;
use RusaDrako\sberbank_ecom_client\Client;
use RusaDrako\sberbank_ecom_client\ClientExpansion;

/**
 * Class SberbankTest
 */
class Sberbank__Test extends TestCase{
	/** @var string Имя класса для тестирования */
	private $className = ClientExpansion::class;
	/** @var mixed|null Объект для тестирования */
	private $object = null;

	/** @var string внутренний номер заказа */
	private $orderNumber = 'тест-1';

	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
//		$params=cfg_db::get_db("sberbank_1");
		$this->object = new $this->className([
			'userName'=>_Login::LOGIN,
			'password'=>_Login::PASSWORD,
			'api_host'=>Client::API_HOST_TEST,
		]);
	}

	/**
	 * Тест на доступность функционала создания заказа
	 * @throws \exception
	 */
	public function test_auth_wrong(){
		$this->object = new $this->className([
			'userName'=>'wrongTest',
			'password'=>'wrongTest',
			'api_host'=>Client::API_HOST_TEST,
		]);

		// Создание заказа (заказ уже существует)
		$result = $this->object->registerOrder($this->orderNumber, 100, 'https://www.test.test/', array());
		$this->assertEquals(5, $result['errorCode']);
		$this->assertEquals("Доступ запрещен", $result['errorMessage']);
	}

	// При полной недоступности действия (например, при непрравильном вызове), возникает ошибка 7 - System error
	// Любые другие ошибки говорят, что мы достучались до функционала, но не можем его выполнить, из-за других ограничений (дублирование, неполнота переданных параметров)

	/**
	 * Тест на доступность функционала создания заказа (заказ уже существует)
	 * @throws \exception
	 */
	public function test_registerOrder(){
		// Создание заказа
		$result = $this->object->registerOrder($this->orderNumber, 100, 'https://www.test.test/', array());

		$this->assertEquals(1, $result['errorCode']);
		$this->assertEquals("Заказ с таким номером уже обработан", $result['errorMessage']);
	}

	/**
	 * Тест на доступность функционала проверки статуса заказа
	 * @throws \exception
	 */
	public function test_getOrderStatus(){
		// Получение статуса заказа по внутреннему номеру заказа
		$result = $this->object->getOrderStatus(null, ['orderNumber'=>$this->orderNumber]);

		$this->assertEquals(0, $result['errorCode']);
		$this->assertEquals("Обработка запроса прошла без системных ошибок", $result['errorMessage']);

		// Получение статуса заказа по номеру заказа в системе оплаты
		$result = $this->object->getOrderStatus($result['attributes'][0]['value'], array());

		$this->assertEquals(0, $result['errorCode']);
		$this->assertEquals("Обработка запроса прошла без системных ошибок", $result['errorMessage']);
	}

	/**
	 * Тест на доступность функционала возврата средств
	 * @throws \exception
	 */
	public function test_refundOrder(){
		// Получение статуса заказа по внутреннему номеру заказа (от СБ)
		$result = $this->object->getOrderStatus(null, ['orderNumber'=>$this->orderNumber]);

		// Заказ не оплачен
		$result = $this->object->refundOrder($result['attributes'][0]['value'], 100, array());

		// Странно, но по документации тут код ошибки 5 должен быть
		$this->assertEquals(7, $result['errorCode']);
		$this->assertEquals("Неверный статус заказа", $result['errorMessage']);
	}

	/**
	 * Тест на доступность функционала возврата средств
	 * @throws \exception
	 * @group dddd
	 */
	public function test_auth_work(){
		$this->object = new $this->className([
			'userName'=>_Login::LOGIN,
			'password'=>_Login::PASSWORD,
			'api_host'=>Client::API_HOST,
		]);

		// Получение статуса заказа по внутреннему номеру заказа (от СБ)
		$result = $this->object->setPermanentPassword(_Login::LOGIN, _Login::PASSWORD, '');

		// Странно, но по документации тут код ошибки 5 должен быть
		$this->assertEquals(7, $result['errorCode']);
		$this->assertEquals("System error", $result['errorMessage']);
	}

}