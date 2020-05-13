<?php

namespace DocDoc\RgsApiClient\Dto;
/**
 * Объект границ метрики для отправки данных в РГС
 */
class MetricRangeDTO implements \JsonSerializable
{
	/**@var string - ключ метрики */
	private $key;

	/** @var string минимальное значение метрики */
	private $minValue;

	/** @var string  максимальное значение метрики */
	private $maxValue;

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		return get_object_vars($this);
	}

	/**
	 * @return string
	 */
	public function getKey(): string
	{
		return $this->key;
	}

	/**
	 * @param string $key
	 */
	public function setKey(string $key): void
	{
		$this->key = $key;
	}

	/**
	 * @return string
	 */
	public function getMinValue(): string
	{
		return $this->minValue;
	}

	/**
	 * @param string $minValue
	 */
	public function setMinValue(string $minValue): void
	{
		$this->minValue = $minValue;
	}

	/**
	 * @return string
	 */
	public function getMaxValue(): string
	{
		return $this->maxValue;
	}

	/**
	 * @param string $maxValue
	 */
	public function setMaxValue(string $maxValue): void
	{
		$this->maxValue = $maxValue;
	}

}
