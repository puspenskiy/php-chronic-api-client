<?php

namespace DocDoc\RgsApiClient\Exception;

use DocDoc\RgsApiClient\Dto\RgsErrorMessageDto;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Базовый класс исключений при работе с РГС Client
 */
abstract class BaseRgsException extends Exception
{
	/** @var ResponseInterface - объект ответа от сервиса РГС */
	private $response;

	/** @var int */
	private $statusCode;

	/** @var string */
	private $responseContents;

	/**
	 * @param ResponseInterface $response
	 * @param string            $message
	 * @param int               $code
	 * @param Throwable|null    $previous
	 */
	public function __construct(ResponseInterface $response, $message = '', $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);

		$this->response = $response;
		$this->statusCode = $response->getStatusCode();
		$this->responseContents = $response->getBody()->getContents();
	}

	/**
	 * Ошибка РГС сервиса
	 */
	public function getRgsErrorMessage(): RgsErrorMessageDto
	{
		return new RgsErrorMessageDto($this->response);
	}

	/**
	 * Ответ от РГС
	 *
	 * @return string
	 */
	public function getResponseContents(): string
	{
		return $this->responseContents;
	}

	/**
	 * Статус ответа от РГС
	 *
	 * @return int
	 */
	public function getStatusCode(): int
	{
		return $this->statusCode;
	}

}
