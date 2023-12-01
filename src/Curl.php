<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Curl
 */
class Curl{

	/** @var int Время ожидания ответа */
	protected $timeout = 15;

	public function __construct(array $options = []){
		$this->timeout = $options['timeout'] ?? $this->timeout;
	}

	/**
	 * Выполняет команду
	 */
	public function request(string $url, string $data) {
		# Запускай curl
		$curl = curl_init();
		$headers = [
			'Content-Type:application/json'
		];
		# Формируем
		$array_curl_set = [
			CURLOPT_URL              => $url,
			CURLOPT_HTTPHEADER       => $headers,
			CURLOPT_RETURNTRANSFER   => TRUE,
			CURLOPT_TIMEOUT          => $this->timeout,
			CURLOPT_SSL_VERIFYHOST   => false,
			CURLOPT_SSL_VERIFYPEER   => false,
			CURLOPT_POST             => TRUE,
			CURLOPT_POSTFIELDS       => $data,
		];
		# Выполняем настройки
		curl_setopt_array($curl, $array_curl_set);
		# Выполняем curl
		$result = curl_exec($curl);
		# Если curl выдал ошибку
		if ($result === false) {
			$error = curl_error($curl);
			curl_close($curl);
			throw new ExceptionCurl($error);
		}
		curl_close($curl);
		# Закрываем соединение
		return $result;
	}

}

class ExceptionCurl extends \Exception {}
