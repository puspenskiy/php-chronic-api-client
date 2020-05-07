<?php

namespace DocDoc\RgsApiClient;

use DocDoc\RgsApiClient\Dto\RgsApiParamsInterface;
use DocDoc\RgsApiClient\Exception\BadRequestRgsException;
use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\Service\PatientBuildService;
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
	/** @var PatientBuildService - сервис создания объекта пациента */
	private $patientBuildService;

	/**
	 * @inheritDoc
	 */
	public function __construct(
		ClientInterface $client,
		RgsApiParamsInterface $apiParams,
		LoggerInterface $logger,
		PatientBuildService $patientBuildService
	)
	{
		parent::__construct($client, $apiParams, $logger);
		$this->patientBuildService = $patientBuildService;
	}

	/**
	 * Создать пациента в сервисе мониторинга РГС
	 *
	 * @param Patient $patient
	 *
	 * @return Patient
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function createPatient(Patient $patient): Patient
	{
		$request = $this->buildRequest('POST', '/api/v1/patient', json_encode($patient));
		return $this->buildPatient($this->send($request));
	}

	/**
	 * Обновить данные пациента в сервисе мониторинга РГС
	 *
	 * @param Patient $patient
	 *
	 * @return Patient
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function updatePatient(Patient $patient): Patient
	{
		$url = '/api/v1/patient/' . $patient->getExternalId();
		$request = $this->buildRequest('PUT', $url, json_encode($patient));
		return $this->buildPatient($this->send($request));
	}

	/**
	 * Получить пациента из сервиса мониторинга РГС.
	 *
	 * @param $externalId
	 *
	 * @return Patient
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function getPatient(int $externalId): Patient
	{
		$url = '/api/v1/patient/' . $externalId;
		$request = $this->buildRequest('PUT', $url, '');

		return $this->buildPatient($this->send($request));
	}

	/**
	 * Активация пациента в системе мониторинга РГС
	 *
	 * @param int $externalId
	 *
	 * @return Patient
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function activate(int $externalId): Patient
	{
		$url = '/api/v1/patient/' . $externalId . '/activate';
		$request = $this->buildRequest('PATCH', $url, '');
		return $this->buildPatient($this->send($request));
	}

	/**
	 * Деактивация пациента в системе мониторинга РГС
	 *
	 * @param int $externalId
	 *
	 * @return Patient
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function inactivate(int $externalId): Patient
	{
		$url = '/api/v1/patient/' . $externalId . '/inactivate';
		$request = $this->buildRequest('PATCH', $url, '');
		return $this->buildPatient($this->send($request));
	}

	/**
	 * Сборка объекта пациента из ответа.
	 *
	 * @param ResponseInterface $response
	 *
	 * @return Patient
	 * @throws
	 */
	private function buildPatient(ResponseInterface $response): Patient
	{
		return $this->patientBuildService->buildAsJson($response->getBody()->getContents());
	}
}
