<?php
namespace RusaDrako\sberbank_ecom_client\Tests;

use PHPUnit\Framework\TestCase;
use RusaDrako\sberbank_ecom_client\Language;

require_once(__DIR__ . '/../src/autoload.php');

/**
 * @author Петухов Леонид <l.petuhov@okonti.ru>
 */
class Language__validate__Test extends TestCase {

	private $className = Language::class;

	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {}

	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}

	/**
	 * Проверка на обязательный параметр
	 */
	public function test__validate() {
		$this->assertTrue(($this->className)::validate(Language::RUS));
		$this->assertFalse(($this->className)::validate('blablabla'));
	}

}
