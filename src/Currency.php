<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Валюта
 */
class Currency{
	/** Цифровые коды валют операций (ISO-4217) */
	const RUB = '643'; // Российский рубль (после деноминации 1998 года)
	const USD = '840'; // Доллар США
	const EUR = '978'; // Евро
	const GBP = '826'; // Фунт Стерлингов
	const CNY = '156'; // Китайский юань
	const JPY = '392'; // Йена
	const CHF = '756'; // Швейцарский франк
	const UAH = '980'; // Гривна

	/**
	 * Проверяет правильность данных
	 */
	public static function validate($data) {
		return in_array($data, [Currency::RUB, Currency::USD, Currency::EUR, Currency::GBP, Currency::CNY, Currency::JPY, Currency::CHF, Currency::UAH])
			? true
			: false;
	}

}
