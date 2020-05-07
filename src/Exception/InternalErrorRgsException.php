<?php

namespace DocDoc\RgsApiClient\Exception;

use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * "Внутренняя ошибка сервера". Сервер столкнулся с ситуацией, которую он не знает как обработать.
 */
class InternalErrorRgsException extends BaseRgsException
{
	public function __construct(
		ResponseInterface $response,
		$message = 'Сервис РГС не смог обработать запрос',
		$code = 0,
		Throwable $previous = null
	)
	{
		parent::__construct($response, $message, $code, $previous);
	}
}
