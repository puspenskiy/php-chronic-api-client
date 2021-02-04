<?php

namespace DocDoc\RgsApiClient;

use DocDoc\RgsApiClient\Enum\CategoryEnum;
use DocDoc\RgsApiClient\Enum\SourceTypeEnum;
use DocDoc\RgsApiClient\Exception\BadRequestRgsException;
use DocDoc\RgsApiClient\Exception\InternalErrorRgsException;
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
	 * Получить список и настройки полей для отрисовки формы
	 * добавления данных в анкету самим пациентом
	 *
	 * @param string $categoryKey - CategoryEnum
	 *
	 * @return ResponseInterface
	 * @throws InternalErrorRgsException
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
	 * Получить список и настройки полей для отрисовки формы
	 * добавления доктором данных в анкету пациента
	 *
	 * @param string $categoryKey - CategoryEnum
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 * @throws InternalErrorRgsException
	 * @see CategoryEnum
	 *
	 */
	public function getFormForDoctor(string $categoryKey): ResponseInterface
	{
		$url = '/api/v1/category/' . $categoryKey . '/form/?source=' . SourceTypeEnum::TELEMED;
		$request = $this->buildRequest('GET', $url, '');

		return $this->send($request);
	}

	/**
	 * Возвращает список и настройки полей для отрисовки формы редактирования нормы пациента
	 *
	 * @param string $categoryKey - CategoryEnum
	 *
	 * @return ResponseInterface
	 * @throws InternalErrorRgsException
	 * @throws BaseRgsException
	 * @see CategoryEnum
	 */
	public function getFormRanges(string $categoryKey): ResponseInterface
	{
		$url = '/api/v1/category/' . $categoryKey . '/form/ranges';
		$request = $this->buildRequest('GET', $url, '');

		return $this->send($request);
	}
}
