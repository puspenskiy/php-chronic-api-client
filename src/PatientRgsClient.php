<?php

namespace DocDoc\RgsApiClient;

use DocDoc\RgsApiClient\Dto\RgsApiParamsInterface;
use DocDoc\RgsApiClient\Exception\BadRequestRgsException;
use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\ValueObject\Patient\Patient;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Клиент РГС АPI для работы с клиентами
 *
 * @see https://chronicmonitor.docs.apiary.io/#reference/patient
 */
class PatientRgsClient extends AbstractRgsClient
{
	/**
	 * @inheritDoc
	 */
	public function __construct(
		ClientInterface $client,
		RgsApiParamsInterface $apiParams,
		LoggerInterface $logger
	)
	{
		parent::__construct($client, $apiParams, $logger);
	}

	/**
	 * Создать пациента в сервисе мониторинга РГС
	 *
	 * @param Patient $patient
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function createPatient(Patient $patient): ResponseInterface
	{
		$request = $this->buildRequest('POST', '/api/v1/patient', json_encode($patient));
		return $this->send($request);
	}

	/**
	 * Обновить данные пациента в сервисе мониторинга РГС
	 *
	 * @param Patient $patient
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function updatePatient(Patient $patient): ResponseInterface
	{
		$url = '/api/v1/patient/' . $patient->getExternalId();
		$request = $this->buildRequest('PUT', $url, json_encode($patient));
		return $this->send($request);
	}

	/**
	 * Получить пациента из сервиса мониторинга РГС.
	 *
	 * @param int $externalId
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function getPatient(int $externalId): ResponseInterface
	{
		$url = '/api/v1/patient/' . $externalId;
		$request = $this->buildRequest('GET', $url, '');

		return $this->send($request);
	}

	/**
	 * Активация пациента в системе мониторинга РГС
	 *
	 * @param int $externalId
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function activate(int $externalId): ResponseInterface
	{
		$url = '/api/v1/patient/' . $externalId . '/activate';
		$request = $this->buildRequest('PATCH', $url, '');
		return $this->send($request);
	}

	/**
	 * Деактивация пациента в системе мониторинга РГС
	 *
	 * @param int $externalId
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function inactivate(int $externalId): ResponseInterface
	{
		$url = '/api/v1/patient/' . $externalId . '/inactivate';
		$request = $this->buildRequest('PATCH', $url, '');
		return $this->send($request);
	}
}
