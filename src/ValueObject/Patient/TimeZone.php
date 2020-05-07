<?php

namespace DocDoc\RgsApiClient\ValueObject\Patient;

use DocDoc\RgsApiClient\Exception\ValidationException;

/**
 * Объект временной зоны
 */
class TimeZone implements \JsonSerializable
{
	/** @var string */
	private $value;

	/**
	 * @param string $timeZone
	 *
	 * @throws ValidationException
	 */
	public function __construct(string $timeZone)
	{
		$this->value = $timeZone;
		if ($this->validate() === false) {
			throw new ValidationException('Time Zone не является допустимым значением');
		}

	}

	private function validate(): bool
	{
		return preg_match('/^([+-](?:2[0-3]|[01][0-9]):[0-5][0-9])$/', $this->value);
	}

	public function jsonSerialize()
	{
		return $this->value;
	}
}
