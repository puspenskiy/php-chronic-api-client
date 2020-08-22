<?php

namespace DocDoc\RgsApiClient\ValueObject;

use DocDoc\RgsApiClient\Exception\ValidationException;

/**
 * Класс предоставляющий способ валидации
 */
abstract class AbstractValidateValueObject
{
	/** @var string[]  Поля для валидации и представления */
	protected $fields;

	/** @var array <string,string> ошибки валидации */
	protected $errors;

	/**
	 * Массив обязательных значений для валидации.
	 *
	 * @return array<string, mixed>
	 */
	abstract protected function getRequiredFields(): array;

	/**
	 * Массив значений для валидации и Json представление объекта.
	 *
	 * @return array<string, string>
	 */
	abstract protected function getFields(): array;

	/**
	 * @return array<string, mixed>
	 * @throws ValidationException
	 */
	public function jsonSerialize(): array
	{
		if ($this->validate() === false) {
			throw new ValidationException('Объект содержит ошибки валидации');
		}
		return $this->getFields();
	}

	/**
	 * Проверка валидности значений объекта.
	 */
	public function validate(): bool
	{
		foreach ($this->getRequiredFields() as $name => $value) {
			if ($value === null) {
				$this->errors[$name] = 'Свойство ' . $name . ' не может быть пустым.';
			}
		}
		return !(bool)$this->errors;
	}
}
