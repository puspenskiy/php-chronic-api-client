<?php

namespace DocDoc\RgsApiClient\Dto;
/**
 * Объект границ метрики для отправки данных в РГС
 */
class MetricRangeDTO implements \JsonSerializable
{
	/**@var string - ключ метрики */
	private $key;

	/** @var string  максимальное значение метрики */
	private $value;

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
	public function getValue(): string
	{
		return $this->value;
	}

	/**
	 * @param string $value
	 */
	public function setValue(string $value): void
	{
		$this->value = $value;
	}

}
