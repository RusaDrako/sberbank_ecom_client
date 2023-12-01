<?php
namespace RusaDrako\sberbank_ecom_client\Tests;

use PHPUnit\Framework\TestCase;
use RusaDrako\sberbank_ecom_client\Response;

require_once(__DIR__ . '/_autoload.php');

/**
 * @author Petukhov Leonid <f182@rambler.ru>
 */
class Response__Test extends TestCase {

	private $className = Response::class;

	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {}

	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}

	/** Проверка получения параметров объекта */
	public function test__options() {
		$json = '{"errorCode":5,"errorMessage":"Доступ запрещен"}';
		$response = new $this->className($json);
		$this->assertEquals(5, $response->errorCode);
		$this->assertEquals("Доступ запрещен", $response->errorMessage);
	}

	/** Метод getJSON() */
	public function test__getJSON() {
		$json = '{"errorCode":5,"errorMessage":"Доступ запрещен"}';
		$response = new $this->className($json);
		$this->assertEquals($json, $response->getJSON());
	}

	/** Метод getArray() */
	public function test__getArray() {
		$json = '{"errorCode":5,"errorMessage":"Доступ запрещен"}';
		$response = new $this->className($json);
		$this->assertEquals(['errorCode' => 5, 'errorMessage' => 'Доступ запрещен'], $response->getArray());
	}

}
