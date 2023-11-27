<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Объект ответа
 */
class Response extends Item{

	/** @var string */
	private $_jsonOptions;

	/** */
	public function __construct(string $jsonOptions){
		$this->_jsonOptions = $jsonOptions;
		parent::__construct(\json_decode($this->_jsonOptions, true));
	}

	/**
	 * Возвращает результат запроса в формате JSON
	 * @return string
	 */
	public function getJSON() {
		return $this->_jsonOptions;
	}

	/**
	 * Возвращает результат запроса в формате Array
	 * @return array
	 */
	public function getArray() {
		return $this->_options;
	}

}
