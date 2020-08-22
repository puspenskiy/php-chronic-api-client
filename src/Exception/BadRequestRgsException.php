<?php

namespace DocDoc\RgsApiClient\Exception;

use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * "Плохой запрос". Этот ответ означает, что сервер не понимает запрос из-за неверного синтаксиса 4xx.
 */
class BadRequestRgsException extends BaseRgsException
{
	public function __construct(
		ResponseInterface $response,
		$message = 'Сервис РГС не смог обработать запрос',
		$code = 0,
		Throwable $previous = null
	) {
		parent::__construct($response, $message, $code, $previous);
	}
}
