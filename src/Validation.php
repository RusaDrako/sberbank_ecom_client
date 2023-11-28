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
			Options::SET_ENUM       => null,
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

		// Обработка по типу
		switch($options[Options::SET_TYPE]){
			// Число
			case Options::TYPE_INT:
			case Options::TYPE_NUM:
				if (!static::validateMinNum($value, $options[Options::SET_MIN])) {
					throw new ExceptionValidation("{$optionName}: Значение '{$value}' меньше ограничения '{$options[Options::SET_MIN]}'");
				}
				if (!static::validateMaxNum($value, $options[Options::SET_MAX])) {
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
			// Объект
			case Options::TYPE_OBJECT:
				if (!static::validateMinArr($value, $options[Options::SET_MIN])) {
					throw new ExceptionValidation("{$optionName}: Количество элементов '{$value}' меньше {$options[Options::SET_MIN]}");
				}
				if (!static::validateMaxArr($value, $options[Options::SET_MAX])) {
					throw new ExceptionValidation("{$optionName}: Количество элементов '{$value}' больше {$options[Options::SET_MAX]}");
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

	/** Проверяет, минимальное значение параметра (число) */
	public static function validateMinNum($value, $option){
		if ($value === null) {return true;}
		if ($option === null) {return true;}
		if ($option <= $value) {return true;}
		return false;
	}

	/** Проверяет, максимальное значение параметра (число) */
	public static function validateMaxNum($value, $option){
		if ($value === null) {return true;}
		if ($option === null) {return true;}
		if ($option >= $value) {return true;}
		return false;
	}

	/** Проверяет, минимальное значение параметра (строка) */
	public static function validateMinStr($value, $option){
		if ($value === null) {return true;}
		if ($option === null) {return true;}
		if ($option <= strlen($value)) {return true;}
		return false;
	}

	/** Проверяет, максимальное значение параметра (строка) */
	public static function validateMaxStr($value, $option){
		if ($value === null) {return true;}
		if ($option === null) {return true;}
		if ($option >= strlen($value)) {return true;}
		return false;
	}

	/** Проверяет, минимальное значение параметра (массив) */
	public static function validateMinArr($value, $option){
		if ($value === null) {return true;}
		if ($option === null) {return true;}
		if (is_array($value) && $option <= count($value)) {return true;}
		return false;
	}

	/** Проверяет, максимальное значение параметра (массив) */
	public static function validateMaxArr($value, $option){
		if ($value === null) {return true;}
		if ($option === null) {return true;}
		if (is_array($value) && $option >= count($value)) {return true;}
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
