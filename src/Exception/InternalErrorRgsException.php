<?php

namespace DocDoc\RgsApiClient\Exception;

use Exception;
use Throwable;

/**
 * "Внутренняя ошибка сервера". Сервер столкнулся с ситуацией, которую он не знает как обработать 5xx.
 */
class InternalErrorRgsException extends Exception
{
	public function __construct(
		$message = 'Сервис РГС не смог обработать запрос',
		$code = 0,
		Throwable $previous = null
	) {
		parent::__construct($message, $code, $previous);
	}
}
