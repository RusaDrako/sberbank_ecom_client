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
		$arrActions = array_keys($options->getExistsActions());
		$curl = new Curl();

		foreach($arrActions as $v) {
			// Callback-уведомления не обрабатываем
			if (in_array($v, $this->callbackNotifications)) { continue; }

			$response = $curl->request($client->getUrlAction($v), '{"userName":"' . _Login::LOGIN . '","' . _Login::PASSWORD . '"}');
			$arr = \json_decode($response, true);

			// Надо смотреть почему 7
			if (in_array($v, [
				'paymentDirectMirPay.do',
				'getReceiptStatus',
				'retryReceipt',
				'doReceipt',
			])) {
				$this->assertEquals(7, $arr['errorCode'], $v);
				$this->assertEquals("System error", $arr['errorMessage'], $v);
			// Другой формат ответа
			} else if (in_array($v, [
				'paymentOrderBySubscription',
				'recurrentPayment.do',
			])) {
				$this->assertEquals(5, $arr['error']['code'], $v);
				$this->assertEquals("Error, value of the request parameter", $arr['error']['description'], $v);
			} else {
				$this->assertEquals(5, $arr['errorCode'], $v);
				$this->assertEquals("Error, value of the request parameter", $arr['errorMessage'], $v);
			}
		}
	}

}
