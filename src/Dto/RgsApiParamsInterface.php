<?php

namespace DocDoc\RgsApiClient\Dto;

/**
 * Интерфейс настроек для Json Rpc Api docdoc
 *
 * @see https://chronicmonitor.docs.apiary.io/#reference/
 */
interface RgsApiParamsInterface
{
	/**
	 * URL точка входа
	 */
	public function getHost(): string;

	/**
	 * Id партнера владельца API
	 */
	public function getPartnerId(): int;

}
