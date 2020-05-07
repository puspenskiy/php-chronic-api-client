<?php

namespace DocDoc\RgsApiClient\Exception;

use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 *  Сущность не найдена
 */
class NotFoundRgsException extends BaseRgsException
{

	public function __construct(
		ResponseInterface $response,
		$message = 'Запрашиваемая сущность не найдена',
		$code = 0,
		Throwable $previous = null
	)
	{
		parent::__construct($response, $message, $code, $previous);
	}
}
