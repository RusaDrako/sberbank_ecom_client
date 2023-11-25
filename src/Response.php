<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Объект ответа
 */
class Response extends Item{
	/** */
	public function __construct(array $options){
		$this->options = $options;
	}
}
