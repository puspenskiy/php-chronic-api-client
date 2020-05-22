<?php

namespace DocDoc\RgsApiClient\Dto;

/**
 * Объект метрик для отправки данных в РГС
 *
 * @deprecated 22.05.20 - Не используется на стороне РГС
 */
class MetricsDTO implements \JsonSerializable
{
	/** @var MetricDTO[] */
	private $metric;

	/** @var int */
	private $externalId;

	/**
	 * @param int $externalId
	 */
	public function __construct(int $externalId)
	{
		$this->externalId = $externalId;
	}

	/**
	 * Добавить метрику
	 *
	 * @param MetricDTO $metric
	 */
	public function addMetric(MetricDTO $metric): void
	{
		$this->metric[] = $metric;
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		return $this->metric;
	}

	/**
	 * @return int
	 */
	public function getExternalId(): int
	{
		return $this->externalId;
	}
}
