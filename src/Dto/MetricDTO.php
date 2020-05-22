<?php

namespace DocDoc\RgsApiClient\Dto;

use DateTimeImmutable;
use DocDoc\RgsApiClient\Enum\SourceTypeEnum;

/**
 * Объект метрики для отправки данных в РГС
 */
class MetricDTO implements \JsonSerializable
{
	/** @var \DateTimeImmutable Дата создания */
	private $dateTime;

	/**
	 * @var string источник записи
	 * @see SourceTypeEnum
	 */
	private $source;

	/** @var array значения метрики */
	private $values;

	/** @var int - Id пациента в системе b2b */
	private $externalId;

	/**
	 * @param int $externalId
	 */
	public function __construct(int $externalId)
	{
		$this->externalId = $externalId;
	}

	public function jsonSerialize()
	{
		return [
			'date' => $this->getDateTime()->format('Y-m-d'),
			'time' => $this->getDateTime()->format('H:i:s.000\Z'),
			'source' => $this->getSource(),
			'values' => $this->getValues(),
		];
	}

	/**
	 * @return DateTimeImmutable
	 */
	public function getDateTime(): DateTimeImmutable
	{
		return $this->dateTime;
	}

	/**
	 * @param DateTimeImmutable $dateTime
	 */
	public function setDateTime(DateTimeImmutable $dateTime): void
	{
		$this->dateTime = $dateTime;
	}

	/**
	 * @return string
	 */
	public function getSource(): string
	{
		return $this->source ?: SourceTypeEnum::B2B;
	}

	/**
	 * @param string $source
	 */
	public function setSource(string $source): void
	{
		$this->source = $source;
	}

	/**
	 * @return array
	 */
	public function getValues(): array
	{
		return $this->values;
	}

	/**
	 * @param array $values
	 */
	public function setValues(array $values): void
	{
		$this->values = $values;
	}

	/**
	 * @return int
	 */
	public function getExternalId(): int
	{
		return $this->externalId;
	}

}
