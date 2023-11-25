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
	/** @var Настройки параметров */
	protected $setOption;
	/** @var array Параметры действия подготовленные для JSON */
	protected $optionsForJSON = [];

	/** */
	public function __debugInfo(){
		return array_merge(
			[
				'parent' => is_object($this->_parent)
					? get_class($this->_parent)
					: $this->_parent,
				'actionName' => $this->actionName,
			],
			parent::__debugInfo(),
			[
				'optionsForJSON' => $this->optionsForJSON,
			]
		);
	}

	/** */
	public function __construct(string $actionName){
		$this->actionName = $actionName;
		$this->setOption = Options::getActionOptions($actionName);
		$this->options = array_fill_keys(array_keys($this->setOption), null);
		$this->isFree = !(bool)$this->setOption;
	}

	/** */
	public function __get($name){
		// Если свободное дейсмтвие
		if ($this->isFree) {
			return $this->options[$name] ?? null;
		}
		parent::__get($name);
	}

	/** */
	public function __set($name, $value){
		// Если свободное дейсмтвие
		if ($this->isFree) {
			$this->options[$name] = $value;
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

	/** Выполняет валидацию, подготовку данных и запрос */
	public function execute(){
		if ($this->isFree) {
			$this->options = array_merge($this->options, $this->_parent->getOptions());
			$this->optionsForJSON = $this->options;
		} else {
			$this->options = Client::optionsMerge($this->options, $this->_parent->getOptions());
			$this->validateOptions();
			$this->formatOptions();
		}
		$result = $this->_parent->execute($this);
		return new Response($result);
	}

	/** Выполняет валидацию данных */
	public function validateOptions() {
		$this->optionsForJSON = [];
		foreach($this->setOption as $k => $v) {
			$value = $this->options[$k];
			Validation::validate($k, $value, $v);
			if ($value !== null) {
				$this->optionsForJSON[$k] = $value;
			}
		}
	}

	/** Выполняет форматирование данных */
	public function formatOptions(){
		foreach($this->optionsForJSON as $k => $v) {
			$this->optionsForJSON[$k] = Format::format($v, $this->setOption[$k]);
		}
	}

}

class ExceptionAction extends \Exception {}
