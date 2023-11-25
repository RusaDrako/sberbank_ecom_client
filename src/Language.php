<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Язык
 */
class Language{
	/** Коды языков(ISO 639-1) */
	const RUS = 'ru'; // Русский
	const ENG = 'en'; // Английский

	/**
	 * Проверяет правильность данных
	 */
	public static function validate($data) {
		return in_array($data, [Language::RUS, Language::ENG])
			? true
			: false;
	}
}
