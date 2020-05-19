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

	private static $availableTimezone = [
		-720,
		-660,
		-600,
		-540,
		-480,
		-420,
		-360,
		-300,
		-240,
		-210,
		-180,
		-120,
		-60,
		0,
		60,
		120,
		180,
		210,
		240,
		270,
		300,
		330,
		345,
		360,
		420,
		480,
		540,
		570,
		600,
		660,
		720,
	];

	/**
	 * @param int $timeZone
	 *
	 * @throws ValidationException
	 */
	public function __construct(int $timeZone)
	{
		$this->value = $timeZone;
		if ($this->validate() === false) {
			throw new ValidationException('Time Zone не является допустимым значением');
		}

	}

	private function validate(): bool
	{
		return in_array($this->value, self::$availableTimezone, true);
	}

	public function jsonSerialize()
	{
		return $this->value;
	}
}
