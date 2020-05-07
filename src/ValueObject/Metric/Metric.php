<?php

namespace DocDoc\RgsApiClient\ValueObject\Metric;

use DocDoc\RgsApiClient\Enum\CategoryEnum;

/**
 * Объект метрики
 *
 * @see https://chronicmonitor.docs.apiary.io/#reference/patient/apiv1patientpatientidmetrics/get
 */
class Metric
{
	/**@var string название метрики */
	private $name;

	/**
	 * @var string категория метрики
	 * @see CategoryEnum
	 */
	private $key;

	/**@var array - массив названий полей */
	private $propertiesLabel;

	/** @var string тип измерения */
	private $measurement;

	/** @var array - значения измерений */
	private $values;

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
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
	 * @return array
	 */
	public function getPropertiesLabel(): array
	{
		return $this->propertiesLabel;
	}

	/**
	 * @param array $propertiesLabel
	 */
	public function setPropertiesLabel(array $propertiesLabel): void
	{
		$this->propertiesLabel = $propertiesLabel;
	}

	/**
	 * @return string
	 */
	public function getMeasurement(): string
	{
		return $this->measurement;
	}

	/**
	 * @param string $measurement
	 */
	public function setMeasurement(string $measurement): void
	{
		$this->measurement = $measurement;
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
}
