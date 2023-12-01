<?php
namespace RusaDrako\sberbank_ecom_client\Tests;

use PHPUnit\Framework\TestCase;
use RusaDrako\sberbank_ecom_client\Client;

require_once(__DIR__ . '/_autoload.php');

/**
 * @author Petukhov Leonid <f182@rambler.ru>
 */
class Client__optionsMerge__Test extends TestCase {

	private $className = Client::class;

	private $arr_control = [
		'set_1' => null,
		'set_2' => null,
		'set_3' => null,
	];

	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {}

	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}

	/** Новые параметры пустые */
	public function test__optionsMerge__new_empty() {
		$arr_result = [
			'set_1' => null,
			'set_2' => null,
			'set_3' => null,
		];
		$result = ($this->className)::optionsMerge($this->arr_control, []);
		$this->assertEquals($result, $arr_result);
	}

	/** Новые параметры перекрывают все контрольные настройки */
	public function test__optionsMerge__new_full() {
		$arr_new = [
			'set_1' => 1,
			'set_2' => 2,
			'set_3' => 3,
		];
		$arr_result = [
			'set_1' => 1,
			'set_2' => 2,
			'set_3' => 3,
		];
		$result = ($this->className)::optionsMerge($this->arr_control, $arr_new);
		$this->assertEquals($result, $arr_result);
	}

	/** Новые параметры не пересекаются с контрольными настройками */
	public function test__optionsMerge__new_not() {
		$arr_new = [
			'set_4' => 4,
			'set_5' => 5,
		];
		$arr_result = [
			'set_1' => null,
			'set_2' => null,
			'set_3' => null,
		];
		$result = ($this->className)::optionsMerge($this->arr_control, $arr_new);
		$this->assertEquals($result, $arr_result);
	}

	/** Новые параметры частично пересекаются с контрольными настройками */
	public function test__optionsMerge__new_mixed() {
		$arr_new = [
			'set_2' => 2,
			'set_3' => '',
			'set_6' => 6,
		];
		$arr_result = [
			'set_1' => null,
			'set_2' => 2,
			'set_3' => '',
		];
		$result = ($this->className)::optionsMerge($this->arr_control, $arr_new);
		$this->assertEquals($result, $arr_result);
	}

}
