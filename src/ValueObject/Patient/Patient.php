<?php

namespace DocDoc\RgsApiClient\ValueObject\Patient;

use DocDoc\RgsApiClient\Enum\CategoryEnum;
use DocDoc\RgsApiClient\Enum\RobotTypeEnum;
use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use JsonSerializable;

/**
 * Объект пациента РГС
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания пациента в сервисе РГС
 *
 * @see https://chronicmonitor.docs.apiary.io/#reference/patients/apiv1patient/post
 */
class Patient extends AbstractValidateValueObject implements JsonSerializable
{
	/**
	 * @var string категория пациента
	 * @see CategoryEnum
	 */
	private $categoryKey;

	/** @var string имя */
	private $firstName;

	/** @var string | null отчество */
	private $patronymic;

	/** @var string телефон */
	private $phone;

	/** @var int */
	private $externalId;

	/** @var MetaData */
	private $metadata;

	/** @var TimeZone временная зона */
	private $timezone;

	/** @var bool Статус активности пациента в системе мониторинга */
	private $active = true;

	/** @var bool Статус активности пуш/робот систем для этого пациента */
	private $monitoringEnabled = true;

	/** @var string|null робот для совершения звонка */
	private $robotType;

	/**
	 * @return string
	 * @see CategoryEnum
	 */
	public function getCategoryKey(): string
	{
		return $this->categoryKey;
	}

	/**
	 * @param string $categoryKey
	 *
	 * @see CategoryEnum
	 */
	public function setCategoryKey(string $categoryKey): void
	{
		$this->categoryKey = $categoryKey;
	}

	/**
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->firstName;
	}

	/**
	 * @param string $firstName
	 */
	public function setFirstName(string $firstName): void
	{
		$this->firstName = $firstName;
	}

	/**
	 * @return string|null
	 * @see CategoryEnum
	 */
	public function getPatronymic(): ?string
	{
		return $this->patronymic;
	}

	/**
	 * @param string|null $patronymic
	 */
	public function setPatronymic(?string $patronymic): void
	{
		$this->patronymic = $patronymic;
	}

	/**
	 * @return string
	 */
	public function getPhone(): string
	{
		return $this->phone;
	}

	/**
	 * @param string $phone
	 */
	public function setPhone(string $phone): void
	{
		$this->phone = $phone;
	}

	/**
	 * @return TimeZone
	 */
	public function getTimezone(): TimeZone
	{
		return $this->timezone;
	}

	/**
	 * @param TimeZone $timezone
	 */
	public function setTimezone(TimeZone $timezone): void
	{
		$this->timezone = $timezone;
	}

	/**
	 * @return bool
	 */
	public function isActive(): bool
	{
		return $this->active;
	}

	/**
	 * @return bool
	 */
	public function isMonitoringEnabled(): bool
	{
		return $this->monitoringEnabled;
	}

	/**
	 * @return int
	 */
	public function getExternalId(): int
	{
		return $this->externalId;
	}

	/**
	 * @param int $externalId
	 */
	public function setExternalId(int $externalId): void
	{
		$this->externalId = $externalId;
	}

	/**
	 * @return MetaData
	 */
	public function getMetadata(): MetaData
	{
		return $this->metadata;
	}

	/**
	 * @param MetaData $metadata
	 */
	public function setMetadata(MetaData $metadata): void
	{
		$this->metadata = $metadata;
	}

	/**
	 * @return string|null
	 */
	public function getRobotType(): ?string
	{
		return $this->robotType;
	}

	/**
	 * @param string|null $robotType
	 */
	public function setRobotType(?string $robotType): void
	{
		$this->robotType = $robotType;
	}

	/**
	 * Активировать пользователя в системе мониторинга
	 */
	public function activate(): void
	{
		$this->active = true;
	}

	/**
	 * Отключить пользователя в системе мониторинга
	 */
	public function deactivate(): void
	{
		$this->active = false;
	}

	/**
	 * Включить мониторинг в сервисе РГС
	 */
	public function monitoringEnabled(): void
	{
		$this->monitoringEnabled = true;
	}

	/**
	 * Отключить мониторинг в сервисе РГС
	 */
	public function monitoringDisabled(): void
	{
		$this->monitoringEnabled = false;
	}

	/**
	 * Проверка валидности значений объекта.
	 */
	public function validate(): bool
	{
		parent::validate();
		if (
			CategoryEnum::getValue($this->categoryKey) === null
		) {
			$this->errors['categoryKey'] = 'Не допустимое значение категории пациента';
		}

		if (RobotTypeEnum::getValue($this->robotType) === null) {
			$this->errors['robotType'] = 'Не допустимое значение ' . $this->robotType . ' робота для обзвона';
		}

		return !(bool)$this->errors;
	}

	/**
	 * @inheritDoc
	 */
	protected function getFields(): array
	{
		if ($this->fields !== null) {
			return $this->fields;
		}
		$fields = get_object_vars($this);
		unset($fields['errors'], $fields['fields']);

		if ($this->patronymic === null) {
			unset($fields['patronymic']);
		}

		$this->fields = $fields;
		return $this->fields;
	}

	/**
	 * Массив обязательных значений для валидации.
	 *
	 * @return array<string, mixed>
	 */
	protected function getRequiredFields(): array
	{
		$fields = $this->getFields();
		unset($fields['patronymic'], $fields['robotType']);

		return $fields;
	}

	/**
	 * Список ошибок валидации
	 *
	 * @return array <string, string>
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}
}

