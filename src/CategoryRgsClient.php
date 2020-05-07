<?php

namespace DocDoc\RgsApiClient;

use DocDoc\RgsApiClient\Enum\CategoryEnum;
use DocDoc\RgsApiClient\Exception\BadRequestRgsException;
use DocDoc\RgsApiClient\Exception\BaseRgsException;
use Psr\Http\Message\ResponseInterface;

/**
 * Класс взаимодействия с РГС по сущностям категории
 * Класс является проксирующим, поэтому на выходе всех методов будет ResponseInterface
 *
 * @see https://chronicmonitor.docs.apiary.io/#reference/category/
 */
class CategoryRgsClient extends AbstractRgsClient
{
	/**
	 * Получить список и настройки полей для отрисовки формы добавления данных в анкету
	 *
	 * @param string $categoryKey - CategoryEnum
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 * @see CategoryEnum
	 *
	 */
	public function getForm(string $categoryKey): ResponseInterface
	{
		$url = '/api/v1/category/' . $categoryKey . '/form';
		$request = $this->buildRequest('GET', $url, '');

		return $this->send($request);
	}

	/**
	 * Возвращает список и настройки полей для отрисовки формы редактирования нормы пациента
	 *
	 * @param string $categoryKey - CategoryEnum
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 * @see CategoryEnum
	 */
	public function getFormRanges(string $categoryKey): ResponseInterface
	{
		$url = '/api/v1/category/' . $categoryKey . '/ranges';
		$request = $this->buildRequest('GET', $url, '');

		return $this->send($request);
	}
}
