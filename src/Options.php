<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Класс свойств
 */
class Options{

	/** @var string Имя свойства 'Тип' */
	const SET_TYPE = 'type';
		const TYPE_STR = 'string'; // Строка
		const TYPE_INT = 'int'; // Число
		const TYPE_DATE = 'date'; // Дата
		const TYPE_LNG = 'language'; // Язык
		const TYPE_CUR = 'currency'; // Валюта
		const TYPE_JSON = 'json'; // json
		const TYPE_ENM = 'enum'; // Перечисление
		const TYPE_ENMS = 'enums'; // Перечисление, несколько вариантов
		const TYPE_AMOUNT = 'amount'; // Сумма
	/** @var string Имя свойства 'Обязательное свойство' */
	const SET_REQUIRED = 'required';
	/** @var string Имя свойства 'Минимально значение' */
	const SET_MIN = 'min';
	/** @var string Имя свойства 'Максимальное значение' */
	const SET_MAX = 'max';
	/** @var string Имя свойства 'Hегулярное выражение' */
	const SET_REG_EXP = 'reg_exp';
	/** @var string Имя свойства 'Hегулярное выражение' */
	const SET_ENUM = 'enum_array';

	/** @var array Логин Клиента, полученный при подключении к ПШ */
	const SET_userName = [
		Options::SET_TYPE => Options::TYPE_STR,
		Options::SET_REQUIRED => true,
		Options::SET_MIN => 1,
		Options::SET_MAX => 30,
		Options::SET_REG_EXP => '^[A-Za-z0-9-_ ]+$',
	];
	/** @var array Пароль Клиента, полученный при подключении к ПШ */
	const SET_password = [
		Options::SET_TYPE => Options::TYPE_STR,
		Options::SET_REQUIRED => true,
		Options::SET_MIN => 1,
		Options::SET_MAX => 30,
		Options::SET_REG_EXP => '^[ -~]+$',
	];
	/** @var array Уникальный номер заказа в Платёжном шлюзе */
	const SET_orderId = [
		Options::SET_TYPE => Options::TYPE_STR,
		Options::SET_REQUIRED => 1,
		Options::SET_MIN => 36,
		Options::SET_MAX => 36,
		Options::SET_REG_EXP => '^[a-f0-9\-]+$',
	];
	/** @var array Идентификатор Связки, созданной ранее. Может использоваться, только если у магазина есть разрешение на работу со связками */
	const SET_bindingId = [
		Options::SET_TYPE => Options::TYPE_STR,
		Options::SET_REQUIRED => 1,
		Options::SET_MIN => 36,
		Options::SET_MAX => 36,
		Options::SET_REG_EXP => '^[a-f0-9\-]+$',
	];
	/** @var array Идентификатор Связки, созданной ранее. Может использоваться, только если у магазина есть разрешение на работу со связками */
	const SET_receiptId = [
		Options::SET_TYPE => Options::TYPE_STR,
		Options::SET_REQUIRED => 1,
		Options::SET_MIN => 36,
		Options::SET_MAX => 36,
		Options::SET_REG_EXP => '^[a-f0-9\-]+$',
	];
	/** @var array Цифровой код валюты операции ISO-4217 */
	const SET_currency = [Options::SET_TYPE => Options::TYPE_CUR,];
	/** @var array Сумма операции в минимальных единицах валюты */
	const SET_amount = [
		Options::SET_TYPE => Options::TYPE_INT,
		Options::SET_REQUIRED => 1,
		Options::SET_MIN => 0,
		Options::SET_MAX => 999999999999,
	];
	/** @var array Язык в кодировке ISO 639-1 (ru, en). Если не указан, будет использовано значение по умолчанию, указанное в настройках Клиента */
	const SET_language = [Options::SET_TYPE => Options::TYPE_LNG,];
	/** @var array Блок для передачи дополнительных параметров Клиентом */
	const SET_jsonParams = [Options::SET_TYPE => Options::TYPE_JSON,];
	/** @var array Блок, необходимый для формирования фискальных чеков. Содержит данные фискализации и корзину заказа */
	const SET_orderBundle = [];

	/** @var array Настройки действий */
	private static $actions = [
		// Регистрация заказа
		'register.do' => [
			'userName' => Options::SET_userName,
			'password' => Options::SET_password,
			// Уникальный номер (идентификатор) заказа в системе Клиента
			'orderNumber' => [Options::SET_TYPE => Options::TYPE_STR, Options::SET_REQUIRED => 1, Options::SET_MIN => 1, Options::SET_MAX => 36, Options::SET_REG_EXP => '^[ -~А-Яа-яЁё№]*$'],
			// Сумма операции в минимальных единицах валюты
			'amount' => [Options::SET_TYPE => Options::TYPE_INT, Options::SET_REQUIRED => 1, Options::SET_MIN => 0, Options::SET_MAX => 999999999999],
			'currency' => [Options::SET_currency,],
			// Адрес, на который требуется перенаправить Плательщика в случае успешной оплаты, когда Клиент использует платёжную страницу ПШ
			'returnUrl' => [Options::SET_TYPE => Options::TYPE_STR, Options::SET_REQUIRED => 1, Options::SET_MIN => 12, Options::SET_MAX => 2048, Options::SET_REG_EXP => '^[ -~]*$'],
			// Адрес, на который требуется перенаправить Плательщика в случае неуспешной оплаты, когда Клиент использует платёжную страницу ПШ. Если не указан, используется returnUrl
			'failUrl' => [Options::SET_TYPE => Options::TYPE_STR, Options::SET_MIN => 12, Options::SET_MAX => 2048, Options::SET_REG_EXP => '^[ -~]*$'],
			// Описание заказа в свободной форме на стороне Клиента. Рекомендуемая длина до 99 символов
			'description' => [Options::SET_TYPE => Options::TYPE_STR, Options::SET_MIN => 1, Options::SET_MAX => 512, Options::SET_REG_EXP => '^[ -~А-Яа-яЁё№]*$'],
			'language' => Options::SET_language,
			// Форма отображения платёжной страницы ПШ для Плательщика:
			'pageView' => [Options::SET_TYPE => Options::TYPE_ENM, Options::SET_ENUM => [
				'DESKTOP', // интерфейс для отображения на ПК;
				'MOBILE', // интерфейс для отображения на мобильных устройствах.
			],],
			//Номер (идентификатор) Плательщика в системе Клиента. Используется для реализации функционала Связок
			'clientId' => [Options::SET_TYPE => Options::TYPE_STR, Options::SET_MIN => 1, Options::SET_MAX => 255, Options::SET_REG_EXP => '^[ -~]+$'],
			// Логин дочернего Клиента (если используется)
			'merchantLogin' => [Options::SET_TYPE => Options::TYPE_STR, Options::SET_MIN => 1, Options::SET_MAX => 30, Options::SET_REG_EXP => '^[A-Za-z0-9-_ ]+$'],
			'jsonParams' => Options::SET_jsonParams,
			// Продолжительность жизни заказа в секундах. В случае если параметр не задан, будет использовано значение, указанное в настройках Клиента или время по умолчанию. Если в запросе присутствует параметр expirationDate, то значение параметра sessionTimeoutSecs не учитывается
			'sessionTimeoutSecs' => [Options::SET_TYPE => Options::TYPE_INT, Options::SET_MIN => 0, Options::SET_MAX => 999999999],
			// Дата и время окончания жизни заказа на стороне ПШ в формате yyyy-MM-ddTHH:mm:ss. Если этот параметр не передаётся в запросе, то для определения времени окончания жизни заказа используется sessionTimeoutSecs
			'expirationDate' => [Options::SET_TYPE => Options::TYPE_DATE],
			// Идентификатор Связки, созданной ранее. Может использоваться, только если у магазина есть разрешение на работу со связками
			'bindingId' => [Options::SET_TYPE => Options::TYPE_STR, Options::SET_MIN => 36, Options::SET_MAX => 36, Options::SET_REG_EXP => '^[a-f0-9\-]+$'],
			// Дополнительные параметры управления сценариями при использовании платёжных реквизитов (можно указать несколько через разделитель ";"):
			'features' => [Options::SET_TYPE => Options::TYPE_ENMS, Options::SET_MIN => 1, Options::SET_MAX => 255, Options::SET_REG_EXP => '^[ -~]*$', Options::SET_ENUM => [
				'VERIFY', // Происходит верификация Плательщика без списания средств с его счёта, поэтому в запросе можно передавать нулевую сумму. Даже если сумма платежа будет передана в запросе, она не будет списана со счёта покупателя. После успешной верификации заказ сразу переводится в статус REVERSED (отменён);
				'AUTO_PAYMENT', // Платёж проводится без проверки подлинности владельца карты (без CVC и 3-D Secure). Чтобы проводить подобные платежи и продавца должны быть соответствующие разрешения;
				'FORCE_SSL', // Принудительное проведение платежа без использования 3-D Secure;
				'FORCE_TDS', // Принудительное проведение платежа с использованием 3-D Secure. Если карта не поддерживает 3-D Secure, операция будет отклонена;
				'FORCE_FULL_TDS', // Принудительное проведение платежа только с успешной аутентификацией плательщика 3-D Secure (Y). В противном случае операция будет отклонена.
			],],
			// Номер телефона Плательщика. Если в телефон включён код страны, номер должен начинаться со знака плюс («+»). Если телефон передаётся без знака плюс («+»), то код страны указывать не следует
			'phone' => [Options::SET_TYPE => Options::TYPE_STR, Options::SET_MIN => 1, Options::SET_MAX => 16, Options::SET_REG_EXP => '^(\+?)\d{7,15}$'],
			// Адрес электронной почты Плательщика
			'phone' => [Options::SET_TYPE => Options::TYPE_STR, Options::SET_MIN => 3, Options::SET_MAX => 128, Options::SET_REG_EXP => '^[ -~]+$'],
			'orderBundle' => Options::SET_orderBundle,
		],
		// Регистрация заказа для двухстадийного сценария
		'registerPreAuth.do' => [],
		// Завершение двухстадийного сценария
		'deposit.do' => [],
		// Отмена заказа
		'reverse.do' => [],
		// Возврат средств Плательщика
		'refund.do' => [
			'userName' => Options::SET_userName,
			'password' => Options::SET_password,
			'orderId' => Options::SET_orderId,
			'amount' => Options::SET_amount,
			'language' => Options::SET_language,
			'jsonParams' => Options::SET_jsonParams,
			'orderBundle' => Options::SET_orderBundle,
		],
		// Получение информации о заказе
		'getOrderStatusExtended.do' => [
			'userName' => Options::SET_userName,
			'password' => Options::SET_password,
			'orderId' => Options::SET_orderId,
			'language' => Options::SET_language,
		],
		// Отмена заказа до начала платежа
		'decline.do' => [],

		// Проведение оплаты по карте
		'paymentOrder.do' => [],
		// Проведение оплаты через мобильное приложение "Сбербанк-Онлайн"
		'paymentSberPay.do' => [],
		// Проведение оплаты по подписке СБП
		'paymentOrderBySubscription' => [],

		// Проведение оплаты по связке
		'paymentOrderBinding.do' => [],
		// Деактивация связки Плательщика
		'unBindCard.do' => [
			'userName' => Options::SET_userName,
			'password' => Options::SET_password,
			'bindingId' => Options::SET_bindingId,
			'language' => Options::SET_language,
		],
		// Получение связок по идентификатору Плательщика
		'getBindings.do' => [],
		// Получение связок по номеру карты или идентификатору связки Плательщика
		'getBindingsByCardOrId.do' => [],
		// Активация связки Плательщика
		'bindCard.do' => [
			'userName' => Options::SET_userName,
			'password' => Options::SET_password,
			'bindingId' => Options::SET_bindingId,
			'language' => Options::SET_language,
		],
		// Проведение периодического платежа
		'recurrentPayment.do' => [],

		// Проведение платежа с использованием прямого взаимодействия Клиента с MirPay
		'paymentDirectMirPay.do' => [],

		// Завершение 3DS Method
		'finish3dsMethod.do' => [],
		// Завершение аутентификации 3-D Secure
		'finish3dsPayment.do' => [],

		// Получение информации о результате обработки чека
		'getReceiptStatus' => [
			'userName' => Options::SET_userName,
			'password' => Options::SET_password,
			'receiptId' => Options::SET_receiptId,
			// Статус чека
			'receiptStatus' => [Options::SET_TYPE => Options::TYPE_ENM, Options::SET_ENUM => [
				0, // не определен;
				1, // ожидается отправка или переотправка чека
				2, // чек отправлен, ожидание результата обработки
				3, // чек обработан успешно
				4, // ошибка обработки чека
				5, // ошибка отправки чека (исчерпаны попытки отправки)
				6, // некорректные данные для отправки чека
			],],
		],
		// Переотправка чека без изменения Корзины
		'retryReceipt' => [],
		// Создание чека
		'retryReceipt' => [],
	];

	/** Возвращает настройки указанного действия */
	public static function getActionOptions(string $name) {
		if (array_key_exists($name, Options::$actions)) {
			return Options::$actions[$name];
		}
		throw new OptionsValidation("Действие '{$name}' не найдено.");
	}
}

class OptionsValidation extends \Exception {}
