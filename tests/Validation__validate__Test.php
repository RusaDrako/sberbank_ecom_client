<?php
namespace RusaDrako\sberbank_ecom_client\Tests;

use PHPUnit\Framework\TestCase;
use RusaDrako\sberbank_ecom_client\Validation;

require_once(__DIR__ . '/../src/autoload.php');

/**
 * @author Petukhov Leonid <f182@rambler.ru>
 */
class Validation__validate__Test extends TestCase {

	private $className = Validation::class;

	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {}

	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}

	/**
	 * Проверка на обязательный параметр
	 */
	public function test__validateRequered() {
		// Значение обязательное
		// Нулевое значение не проходит
		$this->assertFalse(($this->className)::validateRequered(null, true));
		$this->assertFalse(($this->className)::validateRequered(null, 1));
		$this->assertFalse(($this->className)::validateRequered(null, '1'));

		// Любое не Нулевое значение проходит
		$this->assertTrue(($this->className)::validateRequered(false, true));
		$this->assertTrue(($this->className)::validateRequered('', true));
		$this->assertTrue(($this->className)::validateRequered(0, true));
		$this->assertTrue(($this->className)::validateRequered('0', true));
		$this->assertTrue(($this->className)::validateRequered(1, true));
		$this->assertTrue(($this->className)::validateRequered('1', true));
		$this->assertTrue(($this->className)::validateRequered(true, true));

		$this->assertTrue(($this->className)::validateRequered(false, 1));
		$this->assertTrue(($this->className)::validateRequered('', 1));
		$this->assertTrue(($this->className)::validateRequered(0, 1));
		$this->assertTrue(($this->className)::validateRequered('0', 1));
		$this->assertTrue(($this->className)::validateRequered(1, 1));
		$this->assertTrue(($this->className)::validateRequered('1', 1));
		$this->assertTrue(($this->className)::validateRequered(true, 1));

		$this->assertTrue(($this->className)::validateRequered(false, '1'));
		$this->assertTrue(($this->className)::validateRequered('', '1'));
		$this->assertTrue(($this->className)::validateRequered(0, '1'));
		$this->assertTrue(($this->className)::validateRequered('0', '1'));
		$this->assertTrue(($this->className)::validateRequered(1, '1'));
		$this->assertTrue(($this->className)::validateRequered('1', '1'));
		$this->assertTrue(($this->className)::validateRequered(true, '1'));


		// Значение необязательное
		$this->assertTrue(($this->className)::validateRequered(false, false));
		$this->assertTrue(($this->className)::validateRequered(true, false));
		$this->assertTrue(($this->className)::validateRequered(null, false));
		$this->assertTrue(($this->className)::validateRequered('', false));
		$this->assertTrue(($this->className)::validateRequered(0, false));
		$this->assertTrue(($this->className)::validateRequered('0', false));
		$this->assertTrue(($this->className)::validateRequered(1, false));

		$this->assertTrue(($this->className)::validateRequered(false, null));
		$this->assertTrue(($this->className)::validateRequered(true, null));
		$this->assertTrue(($this->className)::validateRequered(null, null));
		$this->assertTrue(($this->className)::validateRequered('', null));
		$this->assertTrue(($this->className)::validateRequered(0, null));
		$this->assertTrue(($this->className)::validateRequered('0', null));
		$this->assertTrue(($this->className)::validateRequered(1, null));

		$this->assertTrue(($this->className)::validateRequered(false, 0));
		$this->assertTrue(($this->className)::validateRequered(true, 0));
		$this->assertTrue(($this->className)::validateRequered(null, 0));
		$this->assertTrue(($this->className)::validateRequered('', 0));
		$this->assertTrue(($this->className)::validateRequered(0, 0));
		$this->assertTrue(($this->className)::validateRequered('0', 0));
		$this->assertTrue(($this->className)::validateRequered(1, 0));

		$this->assertTrue(($this->className)::validateRequered(false, ''));
		$this->assertTrue(($this->className)::validateRequered(true, ''));
		$this->assertTrue(($this->className)::validateRequered(null, ''));
		$this->assertTrue(($this->className)::validateRequered('', ''));
		$this->assertTrue(($this->className)::validateRequered(0, ''));
		$this->assertTrue(($this->className)::validateRequered('0', ''));
		$this->assertTrue(($this->className)::validateRequered(1, ''));
	}

	/**
	 * Проверка на минимальное значение параметра
	 */
	public function test__validateMinNum() {
		$this->assertTrue(($this->className)::validateMinNum(-20, null));
		$this->assertTrue(($this->className)::validateMinNum(-10, null));
		$this->assertTrue(($this->className)::validateMinNum(0, null));
		$this->assertTrue(($this->className)::validateMinNum(10, null));
		$this->assertTrue(($this->className)::validateMinNum(20, null));
		$this->assertTrue(($this->className)::validateMinNum('', null));
		$this->assertTrue(($this->className)::validateMinNum('aaa', null));
		$this->assertTrue(($this->className)::validateMinNum(null, null));

		$this->assertFalse(($this->className)::validateMinNum(-20, -10));
		$this->assertTrue(($this->className)::validateMinNum(-10, -10));
		$this->assertTrue(($this->className)::validateMinNum(0, -10));
		$this->assertTrue(($this->className)::validateMinNum(10, -10));
		$this->assertTrue(($this->className)::validateMinNum(20, -10));
		$this->assertTrue(($this->className)::validateMinNum('', -10));
		$this->assertTrue(($this->className)::validateMinNum('aaa', -10));
		$this->assertTrue(($this->className)::validateMinNum(null, -10));

		$this->assertFalse(($this->className)::validateMinNum(-20, 0));
		$this->assertFalse(($this->className)::validateMinNum(-10, 0));
		$this->assertTrue(($this->className)::validateMinNum(0, 0));
		$this->assertTrue(($this->className)::validateMinNum(10, 0));
		$this->assertTrue(($this->className)::validateMinNum(20, 0));
		$this->assertTrue(($this->className)::validateMinNum('', 0));
		$this->assertTrue(($this->className)::validateMinNum('aaa', 0));
		$this->assertTrue(($this->className)::validateMinNum(null, 0));

		$this->assertTrue(($this->className)::validateMinNum('ccc', 'bbb'));
		$this->assertTrue(($this->className)::validateMinNum('bbb', 'bbb'));
		$this->assertFalse(($this->className)::validateMinNum('aaa', 'bbb'));

		$this->assertTrue(($this->className)::validateMinNum(true, true));
		$this->assertFalse(($this->className)::validateMinNum(false, true));
		$this->assertTrue(($this->className)::validateMinNum(false, false));
		$this->assertTrue(($this->className)::validateMinNum(true, false));
	}

	/**
	 * Проверка на максимальное значение параметра
	 */
	public function test__validateMaxNum() {
		$this->assertTrue(($this->className)::validateMaxNum(-10, null));
		$this->assertTrue(($this->className)::validateMaxNum(-20, null));
		$this->assertTrue(($this->className)::validateMaxNum(0, null));
		$this->assertTrue(($this->className)::validateMaxNum(10, null));
		$this->assertTrue(($this->className)::validateMaxNum(20, null));
		$this->assertTrue(($this->className)::validateMaxNum('', null));
		$this->assertTrue(($this->className)::validateMaxNum('aaa', null));
		$this->assertTrue(($this->className)::validateMaxNum(null, null));

		$this->assertTrue(($this->className)::validateMaxNum(-10, 10));
		$this->assertTrue(($this->className)::validateMaxNum(-20, 10));
		$this->assertTrue(($this->className)::validateMaxNum(0, 10));
		$this->assertTrue(($this->className)::validateMaxNum(10, 10));
		$this->assertFalse(($this->className)::validateMaxNum(20, 10));
		$this->assertTrue(($this->className)::validateMaxNum('', 10));
		$this->assertTrue(($this->className)::validateMaxNum('aaa', 10));
		$this->assertTrue(($this->className)::validateMaxNum(null, 10));

		$this->assertTrue(($this->className)::validateMaxNum(-20, 0));
		$this->assertTrue(($this->className)::validateMaxNum(-10, 0));
		$this->assertTrue(($this->className)::validateMaxNum(0, 0));
		$this->assertFalse(($this->className)::validateMaxNum(10, 0));
		$this->assertFalse(($this->className)::validateMaxNum(20, 0));
		$this->assertTrue(($this->className)::validateMaxNum('', 0));
		$this->assertTrue(($this->className)::validateMaxNum('aaa', 0));
		$this->assertTrue(($this->className)::validateMaxNum(null, 0));

		$this->assertFalse(($this->className)::validateMaxNum('ccc', 'bbb'));
		$this->assertTrue(($this->className)::validateMaxNum('bbb', 'bbb'));
		$this->assertTrue(($this->className)::validateMaxNum('aaa', 'bbb'));

		$this->assertTrue(($this->className)::validateMaxNum(true, true));
		$this->assertTrue(($this->className)::validateMaxNum(false, true));
		$this->assertTrue(($this->className)::validateMaxNum(false, false));
		$this->assertFalse(($this->className)::validateMaxNum(true, false));
	}

	/**
	 * Проверка на минимальное значение параметра (строка)
	 */
	public function test__validateMinStr() {
		$this->assertTrue(($this->className)::validateMinStr('', null));
		$this->assertTrue(($this->className)::validateMinStr('aaaa', null));
		$this->assertTrue(($this->className)::validateMinStr('aaaaaaaa', null));
		$this->assertTrue(($this->className)::validateMinStr(0, null));
		$this->assertTrue(($this->className)::validateMinStr(10, null));
		$this->assertTrue(($this->className)::validateMinStr(20, null));

		$this->assertFalse(($this->className)::validateMinStr('', 4));
		$this->assertTrue(($this->className)::validateMinStr('aaaa', 4));
		$this->assertTrue(($this->className)::validateMinStr('aaaaaaaa', 4));
		$this->assertFalse(($this->className)::validateMinStr(0, 4));
		$this->assertFalse(($this->className)::validateMinStr(10, 4));
		$this->assertFalse(($this->className)::validateMinStr(20, 4));

	}

	/**
	 * Проверка на максимальное значение параметра (строка)
	 */
	public function test__validateMaxStr() {
		$this->assertTrue(($this->className)::validateMaxStr('', null));
		$this->assertTrue(($this->className)::validateMaxStr('aaaa', null));
		$this->assertTrue(($this->className)::validateMaxStr('aaaaaaaa', null));
		$this->assertTrue(($this->className)::validateMaxStr(0, null));
		$this->assertTrue(($this->className)::validateMaxStr(10, null));
		$this->assertTrue(($this->className)::validateMaxStr(20, null));

		$this->assertTrue(($this->className)::validateMaxStr('', 4));
		$this->assertTrue(($this->className)::validateMaxStr('aaaa', 4));
		$this->assertFalse(($this->className)::validateMaxStr('aaaaaaaa', 4));
		$this->assertTrue(($this->className)::validateMaxStr(0, 4));
		$this->assertTrue(($this->className)::validateMaxStr(10, 4));
		$this->assertTrue(($this->className)::validateMaxStr(20, 4));
	}

	/**
	 * Проверка на минимальное значение параметра (строка)
	 */
	public function test__validateMinArr() {
		$this->assertTrue(($this->className)::validateMinArr('аааа', null));
		$this->assertTrue(($this->className)::validateMinArr(0, null));
		$this->assertTrue(($this->className)::validateMinArr(10, null));
		$this->assertTrue(($this->className)::validateMinArr([], null));
		$this->assertTrue(($this->className)::validateMinArr(['1', '2', '3', '4',], null));

		$this->assertFalse(($this->className)::validateMinArr([], 4));
		$this->assertFalse(($this->className)::validateMinArr('aaaa', 4));
		$this->assertFalse(($this->className)::validateMinArr(0, 4));
		$this->assertFalse(($this->className)::validateMinArr(10, 4));

		$this->assertFalse(($this->className)::validateMinArr(['1', '2', '3',], 4));
		$this->assertTrue(($this->className)::validateMinArr(['1', '2', '3', '4',], 4));
		$this->assertTrue(($this->className)::validateMinArr(['1', '2', '3', '4', '5'], 4));
	}

	/**
	 * Проверка на максимальное значение параметра (строка)
	 */
	public function test__validateMaxArr() {
		$this->assertTrue(($this->className)::validateMaxArr('aaaa', null));
		$this->assertTrue(($this->className)::validateMaxArr(0, null));
		$this->assertTrue(($this->className)::validateMaxArr(10, null));
		$this->assertTrue(($this->className)::validateMaxArr([], null));
		$this->assertTrue(($this->className)::validateMaxArr(['1', '2', '3', '4',], null));

		$this->assertTrue(($this->className)::validateMaxArr([], 4));
		$this->assertFalse(($this->className)::validateMaxArr('aaaa', 4));
		$this->assertFalse(($this->className)::validateMaxArr(0, 4));
		$this->assertFalse(($this->className)::validateMaxArr(10, 4));

		$this->assertTrue(($this->className)::validateMaxArr(['1', '2', '3',], 4));
		$this->assertTrue(($this->className)::validateMaxArr(['1', '2', '3', '4',], 4));
		$this->assertFalse(($this->className)::validateMaxArr(['1', '2', '3', '4', '5'], 4));
	}

	/**
	 * Проверка на максимальное значение параметра
	 */
	public function test__validateRegExp() {
		$reg = '^[A-Za-z0-9-_ ]+$';
		$this->assertTrue(($this->className)::validateRegExp(-10, null));
		$this->assertTrue(($this->className)::validateRegExp(-20, null));
		$this->assertTrue(($this->className)::validateRegExp(0, null));
		$this->assertTrue(($this->className)::validateRegExp(10, null));
		$this->assertTrue(($this->className)::validateRegExp(20, null));
		$this->assertTrue(($this->className)::validateRegExp('', null));
		$this->assertTrue(($this->className)::validateRegExp('aaa', null));
		$this->assertTrue(($this->className)::validateRegExp(null, null));

		$this->assertTrue(($this->className)::validateRegExp('-10', $reg));
		$this->assertTrue(($this->className)::validateRegExp(-20, $reg));
		$this->assertTrue(($this->className)::validateRegExp(0, $reg));
		$this->assertTrue(($this->className)::validateRegExp(10, $reg));
		$this->assertTrue(($this->className)::validateRegExp(20, $reg));
		$this->assertFalse(($this->className)::validateRegExp('', $reg));
		$this->assertTrue(($this->className)::validateRegExp('aaa', $reg));
		$this->assertTrue(($this->className)::validateRegExp(null, $reg));
		$this->assertFalse(($this->className)::validateRegExp('аааа', $reg));
	}

	/**
	 * Проверка формата даты
	 */
	public function test__validateDate() {
		$this->assertTrue(($this->className)::validateDate('2000-12-31T23:59:59'));
		$this->assertTrue(($this->className)::validateDate('2000-01-01T01:01:01'));
		$this->assertFalse(($this->className)::validateDate('2000-12-31 23:59:59'));
		$this->assertFalse(($this->className)::validateDate('2000-12-31'));
	}

}
