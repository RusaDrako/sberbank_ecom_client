<?php
namespace RusaDrako\sberbank_ecom_client\Tests;

use PHPUnit\Framework\TestCase;
use RusaDrako\sberbank_ecom_client\Item;

require_once(__DIR__ . '/../src/autoload.php');

/**
 * @author Петухов Леонид <f182@rambler.ru>
 */
class Item__Test extends TestCase {

	private $className = Item::class;
	private $object;

	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$arr = [
			'option_1' => NULL,
			'option_2' => NULL,
		];
		$this->object = new $this->className($arr);
	}

	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}

	/** Параметры элемента */
	public function test__options() {
		$this->assertNull($this->object->option_1);
		$this->object->option_1 = 1234;
		$this->assertEquals(1234, $this->object->option_1);
	}

	/** Обращение к несуществующему параметру объекта */
	public function test__options__no() {
		$this->expectException('RusaDrako\sberbank_ecom_client\ExceptionItem');
		$this->expectExceptionCode(0);
		$this->expectExceptionMessage("Свойство 'option_3' не задано");
		$this->object->option_3;
	}

}
