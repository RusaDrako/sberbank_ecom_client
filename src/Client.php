<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Клиент для работы с API платёжного шлюза Сбербанка (1.0.4) ( https://ecommerce.sberbank.ru )
 */
class Client{

	const API_HOST = 'https://ecommerce.sberbank.ru/';
	const API_HOST_TEST = 'https://ecomtest.sberbank.ru/';

	private $api_host;
	private $api_service_root = 'ecomm/gw/partner/api/v1/';

	private $options = [
		'userName' => null, // Логин Клиента
		'password' => null, // Пароль Клиента
	];

	/** @var string Время ожидания ответа */
	protected $timeout = 10;

	/**  */
	public function __construct(array $options = []){
		$this->api_host = $options['api_host'] ?? Client::API_HOST_TEST;
		$this->timeout = $options['timeout'] ?? $this->timeout;
		$this->options = Client::optionsMerge($this->options, $options);
	}

	/** Объединяет массивы настроек */
	public static function optionsMerge(array $control, array $new){
		return array_intersect_key(array_merge($control, $new), $control);
	}

	/**
	 * Возвращает свойства Клиента
	 */
	public function getOptions(){
		return $this->options;
	}

	/**
	 * Формирует и выполняет действие
	 * @param string $actionName Имя действия
	 * @param array $options Параметры действия
	 * @return Response
	 */
	public function action(string $actionName, array $options = []){
		$action = $this->getAction($actionName);
		foreach($options as $k => $v){
			$action->{$k} = $v;
		}
		$result = $action->execute();
		return $result;
	}

	/**
	 * Формирует объект действия
	 * @param string $actionName Имя действия
	 */
	public function getAction(string $actionName){
		$action = new Action($actionName);
		$action->setParent($this);
		return $action;
	}

	/**
	 * Выполняет команду
	 * @param Action $action Объект действия
	 * @return array|mixed
	 */
	public function execute(Action $action) {
		# Запускай curl
		$curl = curl_init();
		$headers = [
			'Content-Type:application/json',
		];
		# Формируем
		$array_curl_set = [
			CURLOPT_URL              => "{$this->api_host}{$this->api_service_root}{$action->getActionName()}",
			CURLOPT_HTTPHEADER       => $headers,
			CURLOPT_RETURNTRANSFER   => TRUE,
			CURLOPT_TIMEOUT          => $this->timeout,
			CURLOPT_SSL_VERIFYHOST   => false,
			CURLOPT_SSL_VERIFYPEER   => false,
			CURLOPT_POST             => TRUE,
			CURLOPT_POSTFIELDS       => $action->getOptionsJSON(),
		];
		# Выполняем настройки
		curl_setopt_array($curl, $array_curl_set);
		# Выполняем curl
		$result = curl_exec($curl);
		# Если curl выдал ошибку
		if ($result === false) {
			$error = curl_error($curl);
			curl_close($curl);
			throw new ExceptionClient("Ошибка выполнения запроса '{$action->getActionName()}': {$error}");
		}
		# Закрываем соединение
		curl_close($curl);
		# Декодируем результат
		$arr_result = \json_decode($result, true);
		return $arr_result;
	}

}

class ExceptionClient extends \Exception {}
