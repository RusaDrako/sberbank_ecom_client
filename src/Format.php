<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Класс форматирования свойств
 */
class Format{

	/** Валидация данных */
	public static function format($value, array $options = []){
		if ($value === null) {return $value;}
		$controlOptions = [
			Options::SET_TYPE    => null,
		];
		$options = Client::optionsMerge($controlOptions, $options);

		switch($options[Options::SET_TYPE]) {
			// Строка
			case Options::TYPE_STR:
				$value = (string)$value;
				break;
			// Число
			case Options::TYPE_INT:
				$value = (int)$value;
				break;
			// Дата
			case Options::TYPE_DATE:
				$value = date('Y-m-dTH:i:s', strtotime($value));
				break;
			// Перечисление, несколько вариантов
			case Options::TYPE_ENMS:
				$value = implode(';', $value);
				break;
		}

		return $value;
	}
}
