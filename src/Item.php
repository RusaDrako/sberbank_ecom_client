<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Объект элемента
 */
class Item{
	/** @var Client Объект клиента */
	protected $_parent;
	/** @var array Параметры элемента */
	protected $_options = [];

	/** */
	public function __debugInfo(){
		return $this->_options;
	}

	/** */
	public function __construct(array $arrOptions){
		$this->_options = $arrOptions;
	}

	/** */
	public function __get($name){
		if (array_key_exists($name, $this->_options)) {
			return $this->_options[$name];
		}
		throw new ExceptionItem("Свойство '{$name}' не задано");
	}

	/** */
	public function __set($name, $value){
		if (array_key_exists($name, $this->_options)) {
			$this->_options[$name] = $value;
			return;
		}
		throw new ExceptionItem("Свойство '{$name}' не задано");
	}

	/** */
	public function getParent(){
		return $this->_parent;
	}

	/** */
	public function setParent($obj){
		$this->_parent = $obj;
	}

}

class ExceptionItem extends \Exception {}
