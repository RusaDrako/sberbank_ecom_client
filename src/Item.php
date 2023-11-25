<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Объект элемента
 */
class Item{
	/** @var Client Объект клиента */
	public $_parent;
	/** @var array Параметры элемента */
	protected $options = [];

	/** */
	public function __debugInfo(){
		return $this->options;
	}

	/** */
	public function __get($name){
		if (array_key_exists($name, $this->options)) {
			return $this->options[$name];
		}
		throw new ExceptionItem("Свойство '{$name}' не задано");
	}

	/** */
	public function __set($name, $value){
		if (array_key_exists($name, $this->options)) {
			$this->options[$name] = $value;
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
