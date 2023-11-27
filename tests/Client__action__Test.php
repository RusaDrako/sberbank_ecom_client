<?php
namespace RusaDrako\sberbank_ecom_client\Tests;

use PHPUnit\Framework\TestCase;
use RusaDrako\sberbank_ecom_client\Client;

require_once(__DIR__ . '/../src/autoload.php');

/**
 * @author Петухов Леонид <f182@rambler.ru>
 */
class Client__action__Test extends TestCase {

	private $className = Client::class;

	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {}

	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}

	/** Выполнение запроса действия (с ошибкой) */
	public function test__action() {
		$client = new $this->className([
			'userName'=>'login',
			'password'=>'password',
		]);
		$response = $client->action('register.do', [
			'orderNumber' => 'test',
			'amount' => 100,
			'returnUrl' => 'https://www.test.test/',
		]);
		$this->assertTrue(is_object($response));
		$this->assertEquals('RusaDrako\sberbank_ecom_client\Response', get_class($response));;
		$this->assertEquals(5, $response->errorCode);
		$this->assertEquals("Доступ запрещен", $response->errorMessage);
	}

	/** Получение объекта Action */
	public function test__getAction() {
		$client = new $this->className([
			'userName'=>'login',
			'password'=>'password',
		]);
		$action = $client->getAction('register.do');
		$this->assertTrue(is_object($action));
		$this->assertEquals('RusaDrako\sberbank_ecom_client\Action', get_class($action));;
		$this->assertEquals('register.do', $action->getActionName());
	}

}
