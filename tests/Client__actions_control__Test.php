<?php
namespace RusaDrako\sberbank_ecom_client\Tests;

use PHPUnit\Framework\TestCase;
use RusaDrako\sberbank_ecom_client\Client;
use RusaDrako\sberbank_ecom_client\Curl;

require_once(__DIR__ . '/_autoload.php');

/**
 * @author Petukhov Leonid <f182@rambler.ru>
 */
class Client__actions_control__Test extends TestCase {

	private $className = Client::class;
	private $object = null;
	/** @var string[] Callback-уведомления */
	private $callbackNotifications = [
		'callbackUrl',
		'bindingCallbackUrl',
		'receiptStatusCallbackUrl',
	];

	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$this->object = new $this->className([
			'userName'=>_Login::LOGIN,
			'password'=>_Login::PASSWORD,
		]);
	}

	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}

	/** Выполнение запроса действия (с ошибкой) */
	public function test__actions() {
		$client = $this->object;
		$options = $client->getObjectOptions();
		$arrActionsPath = $options->getExistsActions();
		$curl = new Curl();

		foreach($arrActionsPath as $k=>$v) {
			// Callback-уведомления не обрабатываем
			if (in_array($k, $this->callbackNotifications)) { continue; }

			$response = $curl->request($client->getUrlAction($v), '{"userName":"' . _Login::LOGIN . '","' . _Login::PASSWORD . '"}');
			$arr = \json_decode($response, true);

			// Надо смотреть почему 7
			if (in_array($k, [
				'paymentDirectMirPay.do',
			])) {
				$this->assertEquals(7, $arr['errorCode'], $k);
				$this->assertEquals("System error", $arr['errorMessage'], $k);
			// Другой формат ответа
			} else if (in_array($k, [
				'recurrentPayment.do',
				'paymentDirectMirPay.do',
			])) {
				$this->assertEquals(5, $arr['error']['code'], $k);
				$this->assertEquals("Error, value of the request parameter", $arr['error']['description'], $k);
			// Система ofd
			} else if (in_array($k, [
				'getReceiptStatus',
				'retryReceipt',
				'doReceipt',
			])) {
				$this->assertStringContainsString('The requested URL was rejected', $response, $k);
			} else {
				$this->assertEquals(5, $arr['errorCode'], $k);
				$this->assertEquals("Error, value of the request parameter", $arr['errorMessage'], $k);
			}
		}
	}

}
