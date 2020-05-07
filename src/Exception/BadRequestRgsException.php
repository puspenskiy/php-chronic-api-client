<?php

namespace DocDoc\RgsApiClient\Exception;

use Exception;
use Throwable;

/**
 * "Плохой запрос". Этот ответ означает, что сервер не понимает запрос из-за неверного синтаксиса.
 */
class BadRequestRgsException extends Exception
{
	public function __construct(
		$message = 'Сервис РГС не смог обработать запрос',
		$code = 0,
		Throwable $previous = null
	)
	{
		parent::__construct($message, $code, $previous);
	}
}
