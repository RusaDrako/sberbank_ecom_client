<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Класс валидации свойств
 */
class Validation{

	/** Валидация данных */
	public static function validate($optionName, $value, array $options = []){
		$controlOptions = [
			Options::SET_TYPE       => null,
			Options::SET_REQUIRED   => null,
			Options::SET_MIN        => null,
			Options::SET_MAX        => null,
			Options::SET_REG_EXP    => null,
			Options::SET_ENUM       => [],
		];
		$options = Client::optionsMerge($controlOptions, $options);

		// Проверяем обязательный параметр
		if (!static::validateRequered($value, $options[Options::SET_REQUIRED])) {
			throw new ExceptionValidation("{$optionName}: Не задан обязательный параметр");
		}

		// Если тип не назначена
		if ($options[Options::SET_TYPE] === null) { return true;}

		// Если переменная не назначена
		if ($value === null) { return true;}

		// Специальные настройки
		switch($options[Options::SET_TYPE]){
			// Валюта
			case Options::TYPE_CUR:
				if (!Currency::validate($value)) {
					throw new ExceptionValidation("{$optionName}: Код валюты '{$value}' указан неверно");
				}
				return true;
				break;
			// Язык
			case Options::TYPE_LNG:
				if (!Language::validate($value)) {
					throw new ExceptionValidation("{$optionName}: Язык '{$value}' указан неверно");
				}
				return true;
				break;
			// Перечисление
			case Options::TYPE_ENM:
				if (!in_array($value, $options[Options::SET_ENUM])) {
					throw new ExceptionValidation("{$optionName}: Значение '{$value}' отсутствует в перечислении '" . implode('\', \'', $options[Options::SET_ENUM]) . "'");
				}
				return true;
				break;
			// Перечисление, несколько вариантов
			case Options::TYPE_ENMS:
				foreach($value as $v) {
					if (in_array($v, $options[Options::SET_ENUM])) {
						throw new ExceptionValidation("{$optionName}: Значение '{$v}' отсутствует в перечислении '" . implode('\', \'', $options[Options::SET_ENUM]) . "'");
					}
				}
				return true;
				break;
			// JSON
			case Options::TYPE_JSON:
				if (count($value) > 99) {
					throw new ExceptionValidation("{$optionName}: Количество элементов больше 99");
				}
				return true;
				break;
			// Дата
			case Options::TYPE_DATE:
				if (!static::validateDate($value)) {
					throw new ExceptionValidation("{$optionName}: Формат даты указан неверно' {$value}' -> 'yyyy-MM-ddTHH:mm:ss'");
				}
				return true;
				break;
		}

		// Обработка по типу
		switch($options[Options::SET_TYPE]){
			// Число
			case Options::TYPE_INT:
				if (!static::validateMin($value, $options[Options::SET_MIN])) {
					throw new ExceptionValidation("{$optionName}: Значение '{$value}' меньше ограничения '{$options[Options::SET_MIN]}'");
				}
				if (!static::validateMax($value, $options[Options::SET_MAX])) {
					throw new ExceptionValidation("{$optionName}: Значение '{$value}' больше ограничения '{$options[Options::SET_MAX]}'");
				}
				break;
			// Строка
			case Options::TYPE_STR:
				if (!static::validateMinStr($value, $options[Options::SET_MIN])) {
					throw new ExceptionValidation("{$optionName}: Длинна '{$value}' меньше {$options[Options::SET_MIN]} символов");
				}
				if (!static::validateMaxStr($value, $options[Options::SET_MAX])) {
					throw new ExceptionValidation("{$optionName}: Длинна '{$value}' больше {$options[Options::SET_MAX]} символов");
				}
				break;
		}

		if ($options[Options::SET_TYPE] == Options::TYPE_STR) {
			if (!static::validateRegExp($value, $options[Options::SET_REG_EXP])) {
				throw new ExceptionValidation("{$optionName}: Значение '{$value}' не соответствует регулярному выражению '{$options[Options::SET_REG_EXP]}'");
			}
		}
		return true;
	}

	/** Проверяет, является ли параметр обязательным */
	public static function validateRequered($value, $option){
		if (!$option) {return true;}
		if ($value !== null) {return true;}
		return false;
	}

	/** Проверяет, минимальное значение параметра */
	public static function validateMin($value, $option){
		if ($value === null) {return true;}
		if ($option === null) {return true;}
		if ($option <= $value) {return true;}
		return false;
	}

	/** Проверяет, максимальное значение параметра */
	public static function validateMax($value, $option){
		if ($value === null) {return true;}
		if ($option === null) {return true;}
		if ($option >= $value) {return true;}
		return false;
	}

	/** Проверяет, минимальное значение параметра */
	public static function validateMinStr($value, $option){
		if ($value === null) {return true;}
		if ($option === null) {return true;}
		if ($option <= strlen($value)) {return true;}
		return false;
	}

	/** Проверяет, максимальное значение параметра */
	public static function validateMaxStr($value, $option){
		if ($value === null) {return true;}
		if ($option === null) {return true;}
		if ($option >= strlen($value)) {return true;}
		return false;
	}

	/** Проверяет, соответствие регулярному выражению */
	public static function validateRegExp($value, $option){
		if ($value === null) {return true;}
		if ($option === null) {return true;}
		$option = '/' . $option . '/iu';
		if (preg_match($option, $value)) {return true;}
		return false;
	}

	public static function validateDate($value, $format = 'Y-m-d H:i:s'){
		if (preg_match('/^[\d]{4}-[\d]{2}-[\d]{2}T[0-2]+[\d]+:[0-5]+[\d]+:[0-5]+[\d]+$/iu', $value)) {return true;}
		return false;
	}

}

class ExceptionValidation extends \Exception {}
