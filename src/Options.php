<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Класс свойств
 */
class Options{

	/** @var string Имя свойства 'Тип' */
	const SET_TYPE = 'type';
		const TYPE_STR = 'string'; // Строка
		const TYPE_INT = 'integer'; // Число
		const TYPE_NUM = 'number'; // Число
		const TYPE_OBJECT = 'object'; // Объект данных (массив)
		const TYPE_BOOL = 'boolean'; // Логический параметр
	/** @var string Имя свойства 'Обязательное свойство' */
	const SET_REQUIRED = 'required';
	/** @var string Имя свойства 'Минимально значение' */
	const SET_MIN = 'min';
	/** @var string Имя свойства 'Максимальное значение' */
	const SET_MAX = 'max';
	/** @var string Имя свойства 'Hегулярное выражение' */
	const SET_REG_EXP = 'reg_exp';
	/** @var string Имя свойства 'Hегулярное выражение' */
	const SET_ENUM = 'enum';

	/** @var array Список доступных действий */
	private $existsActions = [];

	public function __construct($fileData){
		if (!file_exists($fileData)) {
			throw new ExceptionOptionsValidation("Файл настроек '{$fileData}' отсутствует.");
		}
		$json = file_get_contents($fileData);
		$this->arrData = json_decode($json, 1);
		$this->setActionOptions($this->arrData);
	}

	/**  */
	public function getExistsActions() {
		return $this->existsActions;
	}

	/** Устанавливает действия, для которых есть настройки */
	private function setActionOptions() {
		$data = array_keys($this->arrData['paths']);
		foreach($data as $v) {
			$arr = \explode('/', $v);
			$key = \array_pop($arr);
			$this->existsActions[$key] = $v;
		}
	}

	/** Возвращает настройки указанного действия */
	public function getActionOptions(string $actionName) {
		// Существует ли настрока действия
		if (array_key_exists($actionName, $this->existsActions)) {
			// Получаем расположение схемы действия
			$schemaName = $this->getBranch(['#', 'paths', $this->existsActions[$actionName], 'post', 'requestBody', 'content', 'application/json', 'schema', '$ref']);
			// Получаем настройки схемы действия
			$optionsSet = $this->getBranch($schemaName);
			// Обрабатываем настройки
			foreach($optionsSet['properties'] ?: [] as $k => $v) {
				$optData = $v;
				// Если есть схема настройки
				if (array_key_exists('$ref', $optData)) {
					$dataSet = $this->getBranch($optData['$ref']);
				// Иначе это массив настроек
				} else {
					$dataSet = $optData;
				}
				// Получаем настройки
				$result[$dataSet['name']]=[
					static::SET_TYPE => $dataSet['type'],
					static::SET_REQUIRED => in_array($dataSet['name'], $optionsSet['required'] ?: []),
					static::SET_MAX => $dataSet['maxLength'] ?: ($dataSet['maximum'] ?: ($dataSet['maxProperties'] ?: null)),
					static::SET_MIN => $dataSet['minLength'] ?: ($dataSet['minimum'] ?: ($dataSet['minProperties'] ?: null)),
					static::SET_REG_EXP => $dataSet['pattern'] ?: null,
					static::SET_ENUM => $dataSet['unum'] ?: null,
				];
			}
			// Обрабатываем настройки (одна из)
			// TODO Оформить обработчик и проверку 'Один из'
			foreach($optionsSet['oneOf'] ?: [] as $k => $v) {
				$optData = array_shift($v['properties']);
				// Если есть схема настройки
				if (array_key_exists('$ref', $optData)) {
					$dataSet = $this->getBranch($optData['$ref']);
					// Иначе это массив настроек
				} else {
					$dataSet = $optData;
				}
				// Получаем настройки
				$result[$dataSet['name']]=[
					static::SET_TYPE => $dataSet['type'],
					// TODO Актуальна при доработке 'Один из' (ошибку)
					//  static::SET_REQUIRED => in_array($dataSet['name'], $v['required']),
					static::SET_REQUIRED => null, // in_array($dataSet['name'], $optionsSet['required']),
					static::SET_MAX => $dataSet['maxLength'] ?: ($dataSet['maximum'] ?: ($dataSet['maxProperties'] ?: null)),
					static::SET_MIN => $dataSet['minLength'] ?: ($dataSet['minimum'] ?: ($dataSet['minProperties'] ?: null)),
					static::SET_REG_EXP => $dataSet['pattern'] ?: null,
					static::SET_ENUM => $dataSet['unum'] ?: null,
				];
			}

			return $result;
		}
		throw new ExceptionOptionsValidation("Действие '{$actionName}' не найдено.");
	}

	/** Возвращает ветку данных */
	private function getBranch($branch) {
		if (!is_array($branch)) {
			$branch = explode('/', $branch);
		}
		$arr = $this->arrData;
		$keyLine = '';
		foreach($branch as $k => $v) {
			if ($k == 0 && $v == '#') continue;
			if (!array_key_exists($v, $arr)) {
				throw new ExceptionOptionsValidation('Отсутствует ветка: ' . $keyLine . $v);
				break;
			}
			$arr = $arr[$v];
			$keyLine .= $v . ' -> ';
		}
		return $arr;
	}

}

class ExceptionOptionsValidation extends \Exception {}
