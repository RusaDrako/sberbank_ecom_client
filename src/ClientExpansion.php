<?php
namespace RusaDrako\sberbank_ecom_client;

/**
 * Расшириный функционал Клиента для работы с API платёжного шлюза Сбербанка
 * Для совместимости с функционалом Voronkovich\sberbank-acquiring-client (v2.8)
 */
class ClientExpansion extends Client{

	/** Базовый класс выполнения действия */
	protected function _getResponseForAction($actionName, $requiredData, $data): array {
		$response = $this->action($actionName, array_merge($requiredData, $data));
		return $response->getArray();
	}


	/**
	 * Register a new order.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:register
	 *
	 * @param int|string $orderNumber An order identifier
	 * @param int        $amount      An order amount
	 * @param string     $returnUrl   An url for redirecting a user after successfull order handling
	 * @param array      $data        Additional data
	 *
	 * @return array A server's response
	 */
	public function registerOrder($orderNumber, int $amount, string $returnUrl, array $data = []): array
	{
		return $this->_getResponseForAction('register.do', [
			'orderNumber' => $orderNumber,
			'amount' => $amount,
			'returnUrl' => $returnUrl,
		], $data);
	}

	/**
	 * Register a new order using a 2-step payment process.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:registerpreauth
	 *
	 * @param int|string $orderNumber An order identifier
	 * @param int        $amount      An order amount
	 * @param string     $returnUrl   An url for redirecting a user after successfull order handling
	 * @param array      $data        Additional data
	 *
	 * @return array A server's response
	 */
	public function registerOrderPreAuth($orderNumber, int $amount, string $returnUrl, array $data = []): array
	{
		return $this->_getResponseForAction('registerPreAuth.do', [
			'orderNumber' => $orderNumber,
			'amount' => $amount,
			'returnUrl' => $returnUrl,
		], $data);
	}

	/**
	 * Register a new credit order.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:register_cart_credit
	 *
	 * @param int|string $orderId   An order identifier
	 * @param int        $amount    An order amount
	 * @param string     $returnUrl An url for redirecting a user after successfull order handling
	 * @param array      $data      Additional data
	 *
	 * @return array A server's response
	 */
	public function registerCreditOrder($orderNumber, int $amount, string $returnUrl, array $data = []): array
	{
		return $this->_getResponseForAction('register.do', [
			'orderNumber' => $orderNumber,
			'amount' => $amount,
			'returnUrl' => $returnUrl,
		], $data);
	}

	/**
	 * Register a new credit order using a 2-step payment process.
	 *
	 * @param int|string $orderId   An order identifier
	 * @param int        $amount    An order amount
	 * @param string     $returnUrl An url for redirecting a user after successfull order handling
	 * @param array      $data      Additional data
	 *
	 * @return array A server's response
	 */
	public function registerCreditOrderPreAuth($orderNumber, int $amount, string $returnUrl, array $data = []): array
	{
		return $this->_getResponseForAction('registerPreAuth.do', [
			'orderNumber' => $orderNumber,
			'amount' => $amount,
			'returnUrl' => $returnUrl,
		], $data);
	}

	/**
	 * Deposit an existing order.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:deposit
	 *
	 * @param int|string $orderId An order identifier
	 * @param int        $amount  An order amount
	 * @param array      $data    Additional data
	 *
	 * @return array A server's response
	 */
	public function deposit($orderId, int $amount, array $data = []): array
	{
		return $this->_getResponseForAction('deposit.do', [
			'orderId' => $orderId,
			'amount' => $amount,
		], $data);
	}

	/**
	 * Reverse an existing order.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:reverse
	 *
	 * @param int|string $orderId An order identifier
	 * @param array      $data    Additional data
	 *
	 * @return array A server's response
	 */
	public function reverseOrder($orderId, array $data = []): array
	{
		return $this->_getResponseForAction('reverse.do', [
			'orderId' => $orderId,
		], $data);
	}

	/**
	 * Refund an existing order.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:refund
	 *
	 * @param int|string $orderId An order identifier
	 * @param int        $amount  An amount to refund
	 * @param array      $data    Additional data
	 *
	 * @return array A server's response
	 */
	public function refundOrder($orderId, int $amount, array $data = []): array
	{
		return $this->_getResponseForAction('refund.do', [
			'orderId' => $orderId,
			'amount' => $amount,
		], $data);
	}

	/**
	 * Get an existing order's status by Sberbank's gateway identifier.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:getorderstatusextended
	 *
	 * @param int|string $orderId A Sberbank's gateway order identifier
	 * @param array      $data    Additional data
	 *
	 * @return array A server's response
	 */
	public function getOrderStatus($orderId, array $data = []): array
	{
		return $this->_getResponseForAction('getOrderStatusExtended.do', [
			'orderId' => $orderId,
		], $data);
	}

	/**
	 * Get an existing order's status by own identifier.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:getorderstatusextended
	 *
	 * @param int|string $orderId An own order identifier
	 * @param array      $data    Additional data
	 *
	 * @return array A server's response
	 */
	public function getOrderStatusByOwnId($orderId, array $data = []): array
	{
		return $this->_getResponseForAction('getOrderStatusExtended.do', [
			'orderId' => $orderId,
		], $data);
	}

	/**
	 * Verify card enrollment in the 3DS.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:verifyEnrollment
	 *
	 * @param string $pan  A primary account number
	 * @param array  $data Additional data
	 *
	 * @return array A server's response
	 */
	public function verifyEnrollment(string $pan, array $data = []): array
	{
		throw new ExceptionClientExpansion("verifyEnrollment->verifyEnrollment.do: Метод не реализован.");
		//$data['pan'] = $pan;
		//
		//return $this->execute($this->prefixDefault . 'verifyEnrollment.do', $data);
	}

	/**
	 * Update an SSL card list.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:updateSSLCardList
	 *
	 * @param int|string $orderId An order identifier
	 * @param array      $data    Additional data
	 *
	 * @return array A server's response
	 */
	public function updateSSLCardList($orderId, array $data = []): array
	{
		throw new ExceptionClientExpansion("updateSSLCardList->updateSSLCardList.do: Метод не реализован.");
		//$data['mdorder'] = (string) $orderId;
		//
		//return $this->execute($this->prefixDefault . 'updateSSLCardList.do', $data);
	}

	/**
	 * Get last orders for merchants.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:getLastOrdersForMerchants
	 *
	 * @param \DateTimeInterface      $from A begining date of a period
	 * @param \DateTimeInterface|null $to   An ending date of a period
	 * @param array          $data Additional data
	 *
	 * @return array A server's response
	 */
	public function getLastOrdersForMerchants(\DateTimeInterface $from, \DateTimeInterface $to = null, array $data = []): array
	{
		throw new ExceptionClientExpansion("getLastOrdersForMerchants->getLastOrdersForMerchants.do: Метод не реализован.");
		//if (null === $to) {
		//	$to = new \DateTime();
		//}
		//
		//if ($from >= $to) {
		//	throw new \InvalidArgumentException('A "from" parameter must be less than "to" parameter.');
		//}
		//
		//$allowedStatuses = [
		//	OrderStatus::CREATED,
		//	OrderStatus::APPROVED,
		//	OrderStatus::DEPOSITED,
		//	OrderStatus::REVERSED,
		//	OrderStatus::DECLINED,
		//	OrderStatus::REFUNDED,
		//];
		//
		//if (isset($data['transactionStates'])) {
		//	if (!is_array($data['transactionStates'])) {
		//		throw new \InvalidArgumentException('A "transactionStates" parameter must be an array.');
		//	}
		//
		//	if (empty($data['transactionStates'])) {
		//		throw new \InvalidArgumentException('A "transactionStates" parameter cannot be empty.');
		//	} elseif (0 < count(array_diff($data['transactionStates'], $allowedStatuses))) {
		//		throw new \InvalidArgumentException('A "transactionStates" parameter contains not allowed values.');
		//	}
		//} else {
		//	$data['transactionStates'] = $allowedStatuses;
		//}
		//
		//$data['transactionStates'] = array_map('Voronkovich\SberbankAcquiring\OrderStatus::statusToString', $data['transactionStates']);
		//
		//if (isset($data['merchants'])) {
		//	if (!is_array($data['merchants'])) {
		//		throw new \InvalidArgumentException('A "merchants" parameter must be an array.');
		//	}
		//} else {
		//	$data['merchants'] = [];
		//}
		//
		//$data['from']              = $from->format($this->dateFormat);
		//$data['to']                = $to->format($this->dateFormat);
		//$data['transactionStates'] = implode(',', array_unique($data['transactionStates']));
		//$data['merchants']         = implode(',', array_unique($data['merchants']));
		//
		//return $this->execute($this->prefixDefault . 'getLastOrdersForMerchants.do', $data);
	}

	/**
	 * Payment order binding.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:paymentOrderBinding
	 *
	 * @param int|string $orderId   An order identifier
	 * @param int|string $bindingId A binding identifier
	 * @param string     $ip        Payer's IP (new)
	 * @param array      $data      Additional data
	 *
	 * @return array A server's response
	 */
	public function paymentOrderBinding($mdOrder, $bindingId, string $ip, array $data = []): array
	{
		return $this->_getResponseForAction('paymentOrderBinding.do', [
			'mdOrder' => $mdOrder,
			'bindingId' => $bindingId,
			'ip' => $ip,
		], $data);
	}

	/**
	 * Activate a binding.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:bindCard
	 *
	 * @param int|string $bindingId A binding identifier
	 * @param array      $data      Additional data
	 *
	 * @return array A server's response
	 */
	public function bindCard($bindingId, array $data = []): array
	{
		return $this->_getResponseForAction('reverse.do', [
			'bindingId' => $bindingId,
		], $data);
	}

	/**
	 * Deactivate a binding.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:unBindCard
	 *
	 * @param int|string $bindingId A binding identifier
	 * @param array      $data      Additional data
	 *
	 * @return array A server's response
	 */
	public function unBindCard($bindingId, array $data = []): array
	{
		return $this->_getResponseForAction('unbindCard.do', [
			'bindingId' => $bindingId,
		], $data);
	}

	/**
	 * Extend a binding.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:extendBinding
	 *
	 * @param int|string          $bindingId  A binding identifier
	 * @param \DateTimeInterface  $newExprity A new expiration date
	 * @param array               $data       Additional data
	 *
	 * @return array A server's response
	 */
	public function extendBinding($bindingId, \DateTimeInterface $newExpiry, array $data = []): array
	{
		throw new ExceptionClientExpansion("extendBinding->extendBinding.do: Метод не реализован.");
		//$data['bindingId'] = (string) $bindingId;
		//$data['newExpiry'] = $newExpiry->format('Ym');
		//
		//return $this->execute($this->prefixDefault . 'extendBinding.do', $data);
	}

	/**
	 * Get bindings.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:getBindings
	 *
	 * @param int|string $clientId A binding identifier
	 * @param array      $data     Additional data
	 *
	 * @return array A server's response
	 */
	public function getBindings($clientId, array $data = []): array
	{
		return $this->_getResponseForAction('getBindings.do', [
			'clientId' => $clientId,
		], $data);
	}

	/**
	 * Get a receipt status.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:getreceiptstatus
	 *
	 * @param string $receiptId A receipt identifier (new)
	 * @param array $data A data
	 *
	 * @return array A server's response
	 */
	public function getReceiptStatus(string $receiptId, array $data): array
	{
		return $this->_getResponseForAction('getReceiptStatus', [
			'receiptId' => $receiptId,
		], $data);
	}

	/**
	 * Pay with Apple Pay.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:payment_applepay
	 *
	 * @param int|string $orderNumber  Order identifier
	 * @param string     $merchant     Merchant
	 * @param string     $paymentToken Payment token
	 * @param array      $data         Additional data
	 *
	 * @return array A server's response
	 */
	public function payWithApplePay($orderNumber, string $merchant, string $paymentToken, array $data = []): array
	{
		throw new ExceptionClientExpansion("payWithApplePay->payment.do: Метод не реализован.");
		//$data['orderNumber'] = (string) $orderNumber;
		//$data['merchant'] = $merchant;
		//$data['paymentToken'] = $paymentToken;
		//
		//return $this->execute($this->prefixApple . 'payment.do', $data);
	}

	/**
	 * Pay with Google Pay.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:payment_googlepay
	 *
	 * @param int|string $orderNumber  Order identifier
	 * @param string     $merchant     Merchant
	 * @param string     $paymentToken Payment token
	 * @param array      $data         Additional data
	 *
	 * @return array A server's response
	 */
	public function payWithGooglePay($orderNumber, string $merchant, string $paymentToken, array $data = []): array
	{
		throw new ExceptionClientExpansion("payWithGooglePay->payment.do: Метод не реализован.");
		//$data['orderNumber'] = (string) $orderNumber;
		//$data['merchant'] = $merchant;
		//$data['paymentToken'] = $paymentToken;
		//
		//return $this->execute($this->prefixGoogle . 'payment.do', $data);
	}

	/**
	 * Pay with Samsung Pay.
	 *
	 * @see https://securepayments.sberbank.ru/wiki/doku.php/integration:api:rest:requests:payment_samsungpay
	 *
	 * @param int|string $orderNumber  Order identifier
	 * @param string     $merchant     Merchant
	 * @param string     $paymentToken Payment token
	 * @param array      $data         Additional data
	 *
	 * @return array A server's response
	 */
	public function payWithSamsungPay($orderNumber, string $merchant, string $paymentToken, array $data = []): array
	{
		throw new ExceptionClientExpansion("payWithSamsungPay->payment.do: Метод не реализован.");
		//$data['orderNumber'] = (string) $orderNumber;
		//$data['merchant'] = $merchant;
		//$data['paymentToken'] = $paymentToken;
		//
		//return $this->execute($this->prefixSamsung . 'payment.do', $data);
	}

	/**
	 * Get QR code for payment through SBP.
	 *
	 * @param int|string $orderId An order identifier
	 * @param array      $data    Additional data
	 *
	 * @return array A server's response
	 */
	public function getSbpDynamicQr($orderId, array $data = []): array
	{
		throw new ExceptionClientExpansion("getSbpDynamicQr->dynamic/get.do: Метод не реализован.");
		//if (empty($this->prefixSbpQr)) {
		//	throw new \RuntimeException('The "prefixSbpQr" option is unspecified.');
		//}
		//
		//$data['mdOrder'] = (string) $orderId;
		//
		//return $this->execute($this->prefixSbpQr . 'dynamic/get.do', $data);
	}

	/**
	 * Get QR code status.
	 *
	 * @param int|string $orderId An order identifier
	 * @param string     $qrId    A QR code identifier
	 * @param array      $data    Additional data
	 *
	 * @return array A server's response
	 */
	public function getSbpQrStatus($orderId, string $qrId, array $data = []): array
	{
		throw new ExceptionClientExpansion("getSbpQrStatus-status.do: Метод не реализован.");
		//if (empty($this->prefixSbpQr)) {
		//	throw new \RuntimeException('The "prefixSbpQr" option is unspecified.');
		//}
		//
		//$data['mdOrder'] = (string) $orderId;
		//$data['qrId']    = $qrId;
		//
		//return $this->execute($this->prefixSbpQr . 'status.do', $data);
	}

	/**
	 * Change the temp password.
	 *
	 * @param int|string $login         Login
	 * @param string     $tmpPassword   Temp Password
	 * @param array      $password      New password
	 *
	 * @return array A server's response
	 */
	public function setPermanentPassword(string $login, string $tmpPassword, string $password): array
	{
		return $this->_getResponseForAction('paymentOrderBinding.do', [
			'login' => $login,
			'tmpPassword' => $tmpPassword,
			'password' => $password,
		], []);
	}

}

class ExceptionClientExpansion extends ExceptionClient {}
