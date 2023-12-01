<?php
namespace RusaDrako\sberbank_ecom_client\Tests;

use PHPUnit\Framework\TestCase;
use RusaDrako\sberbank_ecom_client\OrderStatus;

require_once(__DIR__ . '/_autoload.php');

/**
 * @author Petukhov Leonid <f182@rambler.ru>
 */
class OrderStatus__Test extends TestCase {

	private $className = OrderStatus::class;
	private $object;

	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$this->object=new $this->className();
	}

	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}

	/**
	 * Проверка на обязательный параметр
	 */
	public function test__isFunctions() {
		$this->assertTrue($this->object->isCreated(0));
		$this->assertFalse($this->object->isCreated(1));
		$this->assertFalse($this->object->isCreated(2));
		$this->assertFalse($this->object->isCreated(3));
		$this->assertFalse($this->object->isCreated(4));
		$this->assertFalse($this->object->isCreated(5));
		$this->assertFalse($this->object->isCreated(6));

		$this->assertFalse($this->object->isApproved(0));
		$this->assertTrue($this->object->isApproved(1));
		$this->assertFalse($this->object->isApproved(2));
		$this->assertFalse($this->object->isApproved(3));
		$this->assertFalse($this->object->isApproved(4));
		$this->assertFalse($this->object->isApproved(5));
		$this->assertFalse($this->object->isApproved(6));

		$this->assertFalse($this->object->isDeposited(0));
		$this->assertFalse($this->object->isDeposited(1));
		$this->assertTrue($this->object->isDeposited(2));
		$this->assertFalse($this->object->isDeposited(3));
		$this->assertFalse($this->object->isDeposited(4));
		$this->assertFalse($this->object->isDeposited(5));
		$this->assertFalse($this->object->isDeposited(6));

		$this->assertFalse($this->object->isReversed(0));
		$this->assertFalse($this->object->isReversed(1));
		$this->assertFalse($this->object->isReversed(2));
		$this->assertTrue($this->object->isReversed(3));
		$this->assertFalse($this->object->isReversed(4));
		$this->assertFalse($this->object->isReversed(5));
		$this->assertFalse($this->object->isReversed(6));

		$this->assertFalse($this->object->isRefunded(0));
		$this->assertFalse($this->object->isRefunded(1));
		$this->assertFalse($this->object->isRefunded(2));
		$this->assertFalse($this->object->isRefunded(3));
		$this->assertTrue($this->object->isRefunded(4));
		$this->assertFalse($this->object->isRefunded(5));
		$this->assertFalse($this->object->isRefunded(6));

		$this->assertFalse($this->object->isAuthorizationInitialized(0));
		$this->assertFalse($this->object->isAuthorizationInitialized(1));
		$this->assertFalse($this->object->isAuthorizationInitialized(2));
		$this->assertFalse($this->object->isAuthorizationInitialized(3));
		$this->assertFalse($this->object->isAuthorizationInitialized(4));
		$this->assertTrue($this->object->isAuthorizationInitialized(5));
		$this->assertFalse($this->object->isAuthorizationInitialized(6));

		$this->assertFalse($this->object->isDeclined(0));
		$this->assertFalse($this->object->isDeclined(1));
		$this->assertFalse($this->object->isDeclined(2));
		$this->assertFalse($this->object->isDeclined(3));
		$this->assertFalse($this->object->isDeclined(4));
		$this->assertFalse($this->object->isDeclined(5));
		$this->assertTrue($this->object->isDeclined(6));
	}

	/**
	 * Проверка на обязательный параметр
	 */
	public function test__statusToString() {
		$this->assertEquals('CREATED', $this->object->statusToString(0));
		$this->assertEquals('APPROVED', $this->object->statusToString(1));
		$this->assertEquals('DEPOSITED', $this->object->statusToString(2));
		$this->assertEquals('REVERSED', $this->object->statusToString(3));
		$this->assertEquals('REFUNDED', $this->object->statusToString(4));
		$this->assertEquals('', $this->object->statusToString(5));
		$this->assertEquals('DECLINED', $this->object->statusToString(6));
		$this->assertEquals('', $this->object->statusToString(7));
	}

}
