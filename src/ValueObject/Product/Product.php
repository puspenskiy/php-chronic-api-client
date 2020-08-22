<?php

declare(strict_types=1);

namespace DocDoc\RgsApiClient\ValueObject\Product;

use DocDoc\RgsApiClient\Enum\RobotTypeEnum;
use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use JsonSerializable;

/**
 * Данные продукта для передачи в сервис мониторинга РГС
 */
class Product extends AbstractValidateValueObject implements JsonSerializable
{
	/** @var int */
	private $productId;

	/** @var string */
	private $robotType;

	/**
	 * @param int    $productId - ID b2b продукта для указания настроек.
	 * @param string $robotType -  строка робота для звонков пациентам RobotTypeEnum;
	 */
	public function __construct(int $productId, string $robotType)
	{
		$this->productId = $productId;
		$this->robotType = $robotType;
	}

	/**
	 * Id b2b продукта который будет конфигурироваться на стороне РГС
	 *
	 * @return int
	 */
	public function getProductId(): int
	{
		return $this->productId;
	}

	/**
	 * Настройка - Робот для звонка
	 *
	 * @return string
	 */
	public function getRobotType(): string
	{
		return $this->robotType;
	}

	public function validate(): bool
	{
		parent::validate();
		if (RobotTypeEnum::getValue($this->robotType) === null) {
			$this->errors['robotType'] = 'Не допустимое значение ' . $this->robotType . ' робота для обзвона';
		}
		return !(bool)$this->errors;
	}

	/**
	 * @inheritDoc
	 */
	protected function getRequiredFields(): array
	{
		return $this->getFields();
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

		$this->fields = $fields;
		return $this->fields;
	}
}
