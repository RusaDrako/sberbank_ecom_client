<?php
namespace RusaDrako\sberbank_ecom_client;

$arr_load = [
	'Options.php',
	'OrderStatus.php',
	'Item.php',
	'Currency.php',
	'Language.php',
	'Validation.php',
	'Format.php',
	'Action.php',
	'Response.php',
	'Curl.php',
	'Client.php',
	'ClientExpansion.php',
];

foreach($arr_load as $k => $v) {
	require_once(__DIR__ . '/' . $v);
}
