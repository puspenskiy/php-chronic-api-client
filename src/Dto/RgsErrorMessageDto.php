<?php

namespace DocDoc\RgsApiClient\Dto;

use Psr\Http\Message\ResponseInterface;
use stdClass;

/**
 * Объект ошибки от сервиса РГС
 */
class RgsErrorMessageDto
{
	/** @var  null | StdClass */
	private $body;

	/** @var string оригинальный контент ответа */
	private $contents;

	public function __construct(ResponseInterface $response)
	{
	    $response->getBody()->rewind();
        $this->contents = $response->getBody()->getContents();
        $this->body = json_decode($this->contents, false);
	}

	public function getMessage(): string
	{
		return $this->body->message ?: $this->contents;
	}

	public function getCode(): int
	{
		return $this->body->code ?: 0;
	}

	public function getType(): string
	{
		return $this->body->type ?: '';
	}
}

