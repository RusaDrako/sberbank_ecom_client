<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Статусы заказа
 */
class OrderStatus
{
	/** @var int Заказ успешно зарегистрирован, но еще не оплачен */
	const CREATED = 0;
	/** @var int Сумма заказа успешно удержана (только для двухэтапных платежей) */
	const APPROVED = 1;
	/** @var int Заказ был размещен. Если вы хотите проверить, успешно ли оплачен платеж - используйте эту константу */
	const DEPOSITED = 2;
	/** @var int Заказ был отменен */
	const REVERSED = 3;
	/** @var int Заказ был возвращен */
	const REFUNDED = 4;
	/** @var int Авторизация заказа была инициализирована АСУ эмитента карты */
	const AUTHORIZATION_INITIALIZED = 5;
	/** @var int Заказ был отклонен */
	const DECLINED = 6;

	/** Проверяет соответствие статуса */
	public static function isCreated($status){
		return '' !== $status && self::CREATED === (int) $status;
	}

	public static function isApproved($status){
		return self::APPROVED === (int) $status;
	}

	public static function isDeposited($status){
		return self::DEPOSITED === (int) $status;
	}

	public static function isReversed($status){
		return self::REVERSED === (int) $status;
	}

	public static function isRefunded($status){
		return self::REFUNDED === (int) $status;
	}

	public static function isAuthorizationInitialized($status){
		return self::AUTHORIZATION_INITIALIZED === (int) $status;
	}

	public static function isDeclined($status){
		return self::DECLINED === (int) $status;
	}

	/** Возвращает название статуса по коду */
	public static function statusToString($status){
		switch ((int) $status) {
			case self::CREATED:
				return 'CREATED';
				break;
			case self::APPROVED:
				return 'APPROVED';
				break;
			case self::DEPOSITED:
				return 'DEPOSITED';
				break;
			case self::REVERSED:
				return 'REVERSED';
				break;
			case self::REFUNDED:
				return 'REFUNDED';
				break;
			//case self::AUTHORIZATION_INITIALIZED:
			//	return 'AUTHORIZATION_INITIALIZED';
			//	break;
			case self::DECLINED:
				return 'DECLINED';
				break;
		}

		return '';
	}
}
