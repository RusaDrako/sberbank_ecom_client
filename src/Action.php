<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Объект действия
 */
class Action extends Item{
	/** @var string Имя действия */
	protected $actionName;
	/** @var bool Указатель, что действие не имеет настроек */
	protected $isFree = false;
	/** @var array Настройки параметров */
	protected $setOption;
	/** @var array Параметры действия подготовленные для JSON */
	protected $optionsForJSON = [];

	/** */
	public function __debugInfo(){
		$options = [];
		foreach($this->_options as $k => $v) {
			if ($v !== null) {
				$options[$k] = $v;
			}
		}
		return [
			'parent' => is_object($this->_parent)
				? get_class($this->_parent)
				: $this->_parent,
			'actionName' => $this->actionName,
			'optionsActive' => $options,
//			'optionsSet' => $this->setOption,
			'optionsFull' => parent::__debugInfo(),
			'optionsForJSON' => $this->optionsForJSON,
			'JSON' => $this->getOptionsJSON(),
		];
	}

	/** */
	public function __construct($objectClient, string $actionName){
		$this->actionName = $actionName;
		$this->_parent = $objectClient;
		$this->setOption = $this->_parent->getObjectOptions()->getActionOptions($actionName);
		$this->isFree = !(bool)$this->setOption;
		parent::__construct(\array_fill_keys(array_keys($this->setOption), null));
	}

	/** */
	public function __get($name){
		// Если свободное дейсмтвие
		if ($this->isFree) {
			return $this->_options[$name] ?? null;
		}
		parent::__get($name);
	}

	/** */
	public function __set($name, $value){
		// Если свободное дейсмтвие
		if ($this->isFree) {
			$this->_options[$name] = $value;
			return;
		}
		parent::__set($name, $value);
	}

	/**
	 * Возвращает имя действия
	 * @return string|string
	 */
	public function getActionName(){ return $this->actionName; }

	/** Преобразует данные запроса в JSON */
	public function getOptionsJSON(){
		return json_encode($this->optionsForJSON);
	}

	/** Преобразует данные запроса в JSON без аутентификации */
	public function getOptionsJSONWithNotAuth(){
		$arr = $this->optionsForJSON;
		unset($arr['userName']);
		unset($arr['password']);
		return json_encode($arr);
	}

	/** Выполняет валидацию, подготовку данных и запрос */
	public function execute(){
		if ($this->isFree) {
			$this->_options = array_merge($this->_options, $this->_parent->getOptions());
			$this->optionsForJSON = $this->_options;
		} else {
			$this->_options = Client::optionsMerge($this->_options, $this->_parent->getOptions());
			$this->validateOptions();
			$this->formatOptions();
		}
		$result = $this->_parent->execute($this);
		return new Response($result);
	}

	/** Выполняет валидацию данных */
	protected function validateOptions() {
		$this->optionsForJSON = [];
		foreach($this->setOption as $k => $v) {
			$value = $this->_options[$k];
			Validation::validate($k, $value, $v);
			if ($value !== null) {
				$this->optionsForJSON[$k] = $value;
			}
		}
	}

	/** Выполняет форматирование данных */
	protected function formatOptions(){
		foreach($this->optionsForJSON as $k => $v) {
			$this->optionsForJSON[$k] = Format::format($v, $this->setOption[$k]);
		}
	}

}

class ExceptionAction extends \Exception {}
