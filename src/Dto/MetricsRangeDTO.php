<?php

namespace DocDoc\RgsApiClient\Dto;

/**
 * Объект границ метрик для отправки данных в РГС
 */
class MetricsRangeDTO implements \JsonSerializable
{
	/** @var MetricRangeDTO[] */
	private $metricsRange;

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
	 * Добавить границы
	 *
	 * @param MetricRangeDTO $metric
	 */
	public function addMetricRange(MetricRangeDTO $metric): void
	{
		$this->metricsRange[] = $metric;
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		return $this->metricsRange;
	}

	/**
	 * @return int
	 */
	public function getExternalId(): int
	{
		return $this->externalId;
	}
}
