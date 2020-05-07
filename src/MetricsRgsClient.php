<?php

namespace DocDoc\RgsApiClient;

use DateTimeImmutable;
use DocDoc\RgsApiClient\Dto\MetricsDTO;
use DocDoc\RgsApiClient\Enum\MetricTypeEnum;
use DocDoc\RgsApiClient\Exception\BadRequestRgsException;
use DocDoc\RgsApiClient\Exception\BaseRgsException;
use Psr\Http\Message\ResponseInterface;

/**
 * Класс взаимодействия с РГС по сущностям метрики
 * Класс является проксирующим, поэтому на выходе всех методов будет ResponseInterface
 *
 * @see https://chronicmonitor.docs.apiary.io/#reference/patient/apiv1patientpatientidmetricslast/get
 */
class MetricsRgsClient extends AbstractRgsClient
{
	/**
	 * Получение данных анкетирования по указанному пациенту по фильтрам даты и по типу длины данных день|неделя|месяц
	 *
	 * @param int                    $externalId
	 * @param DateTimeImmutable|null $from
	 * @param string                 $type - @see MetricType
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function getMetrics(
		int $externalId,
		?DateTimeImmutable $from = null,
		$type = MetricTypeEnum::WEEK
	): ResponseInterface
	{
		$url = '/api/v1/patient/' . $externalId . '/metrics?type=' . $type;
		if ($from !== null) {
			$url .= '&from=' . urlencode($from->format(DATE_ATOM));
		}
		$request = $this->buildRequest('GET', $url, '');
		return $this->send($request);
	}

	/**
	 * Добавление данных анкетирования
	 * Метод является прокси, валидация и сборка объекта не нужна
	 *
	 * @param MetricsDTO $metricsDTO
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function createMetrics(MetricsDTO $metricsDTO): ResponseInterface
	{
		$url = '/api/v1/patient/' . $metricsDTO->getExternalId() . '/metrics';
		$request = $this->buildRequest('POST', $url, json_encode($metricsDTO));
		return $this->send($request);
	}

	/**
	 * Изменяет имеющиеся данные в системе на указанное время
	 * Метод является прокси, валидация и сборка объекта не нужна
	 *
	 * @param MetricsDTO $metricsDTO
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function updateMetrics(MetricsDTO $metricsDTO): ResponseInterface
	{
		$url = '/api/v1/patient/' . $metricsDTO->getExternalId() . '/metrics';
		$request = $this->buildRequest('PUT', $url, json_encode($metricsDTO));
		return $this->send($request);
	}

	/**
	 * Получение последних данных по анкете у пациента
	 *
	 * @param int $externalId
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function getMetricsLast(int $externalId): ResponseInterface
	{
		$url = '/api/v1/patient/' . $externalId . '/metrics/last';
		$request = $this->buildRequest('GET', $url, '');

		return $this->send($request);
	}

	/**
	 * Изменяет допустимые границы для указанной метрики/метрик
	 *
	 * @param int    $externalId
	 * @param string $key
	 * @param string $value
	 *
	 * @return ResponseInterface
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function updateMetricsRanges(int $externalId, string $key, string $value): ResponseInterface
	{
		$url = '/api/v1/patient/' . $externalId . '/metrics/ranges';
		$request = $this->buildRequest('PUT', $url, json_encode(['key' => $key, 'value' => $value]));

		return $this->send($request);
	}
}
