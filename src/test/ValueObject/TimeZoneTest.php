<?php

namespace DocDoc\RgsApiClient\ValueObject\test;

use DocDoc\RgsApiClient\Exception\ValidationException;
use DocDoc\RgsApiClient\ValueObject\Patient\TimeZone;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DocDoc\RgsApiClient\ValueObject\Patient\TimeZone
 */
class TimeZoneTest extends TestCase
{
	/**
	 * @dataProvider successDataProvider
	 *
	 * @param string $timeZone
	 *
	 * @throws \DocDoc\RgsApiClient\Exception\ValidationException
	 */
	public function testSuccess(string $timeZone): void
	{
		$timeZoneObject = new TimeZone($timeZone);
		$expected = json_encode($timeZoneObject);
		$actual = '"' . $timeZone . '"';
		$this->assertEquals(
			$expected,
			$actual,
			'Временная зона не соответствует ожидаемой.'
		);
	}

	/**
	 * @inheritDoc
	 */
	public function successDataProvider(): array
	{
		return [
			['+00:00'],
			['+00:30'],
			['+01:30'],
			['+12:30'],
			['+23:30'],
			['+00:00'],
			['+00:30'],
			['+01:30'],
			['+12:30'],
			['+23:30'],
		];
	}

	/**
	 * @dataProvider failDataProvider
	 *
	 * @param string $timeZone
	 *
	 * @throws \DocDoc\RgsApiClient\Exception\ValidationException
	 */
	public function testFail(string $timeZone): void
	{
		$this->expectException(ValidationException::class);
		new TimeZone($timeZone);
	}

	/**
	 * @inheritDoc
	 */
	public function failDataProvider(): array
	{
		return [
			['+25:00'],
			['+25:61'],
			['+1:61'],
			['+1:61'],
			['+1:1'],
			['+1:100'],
			['+100:100'],
			['+100:00'],
			['-25:00'],
			['-25:61'],
			['-1:61'],
			['-1:61'],
			['-1:1'],
			['-1:100'],
			['-100:100'],
			['-100:00'],
		];
	}
}
