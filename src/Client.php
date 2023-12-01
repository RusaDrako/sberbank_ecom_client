<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Клиент для работы с API платёжного шлюза Сбербанка (1.0.4) ( https://ecommerce.sberbank.ru )
 */
class Client{

	/** Боевой хост платёжного шлюза */
	const API_HOST = 'https://ecommerce.sberbank.ru/';
	/** Тестовый хост платёжного шлюза */
	const API_HOST_TEST = 'https://ecomtest.sberbank.ru/';

	/** @var string Активный хост платёжного шлюза */
	protected $api_host;
	/** @var string Корневой путь платёжного шлюза */
	protected $api_service_root = 'ecomm/gw/partner/api/v1/';

	/** @var array Базовые параметры подключения */
	protected $options = [
		'userName' => null, // Логин Клиента
		'password' => null, // Пароль Клиента
		'language' => null, // Язык
		'currency' => null, // Валюта
	];

	/** @var int Время ожидания ответа */
	protected $timeout = 15;

	/** @var string Объект настроек */
	protected $objectOptions;

	/** @var string Последние действие */
	protected $lastAction;

	public function __construct(array $options = []){
		$this->objectOptions = new Options($options['datafile'] ?? (__DIR__ . '/jsonapi/sberbank_ecom_1.0.4.json'));
		$this->api_host = $options['api_host'] ?? static::API_HOST_TEST;
		$this->timeout = $options['timeout'] ?? $this->timeout;
		$this->options = static::optionsMerge($this->options, $options);
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
		$action = new Action($this, $actionName);
		$action->setParent($this);
		return $action;
	}

	/**
	 * Возвращает объект последнего выполненого действия
	 * @param string $actionName Имя действия
	 */
	public function getLastExecutedAction(){
		return $this->lastAction;
	}

	public function getObjectOptions(){
		return $this->objectOptions;
	}

	/**
	 * Выполняет команду
	 * @param Action $action Объект действия
	 * @return array|mixed
	 */
	public function ___execute(Action $action) {
		$this->lastAction = $action;
		$url = "{$this->api_host}{$this->api_service_root}{$action->getActionName()}";
		# Выполняем запросЗапускай curl
		$result = $this->httpClient($url, $action->getOptionsJSON(), $action->getActionName());
		return new Response($result);
	}

	/** Возвращает url действия */
	public function getUrlAction(string $actionName) {
		return "{$this->api_host}{$this->api_service_root}{$actionName}";
	}

	/**
	 * Выполняет команду
	 * @param Action $action Объект действия
	 * @return array|mixed
	 */
	public function execute(Action $action) {
		$this->lastAction = $action;
		$url = $this->getUrlAction($action->getActionName());
		# Выполняем запросЗапускай curl
		$result = $this->httpClient($url, $action->getOptionsJSON(), $action->getActionName());
		return new Response($result);
	}

	/**  */
	public function httpClient($url, $jsonData, $actionName) {
		$objCurl = new Curl(['timeout'=>$this->timeout]);
		try {
			$result = $objCurl->request($url, $jsonData);
		} catch (ExceptionCurl $e) {
			throw new ExceptionClient("Ошибка выполнения запроса '{$actionName}': {$e->getMessage()}");
		}
		return $result;
	}

}

class ExceptionClient extends \Exception {}
