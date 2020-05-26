<?php

namespace DocDoc\RgsApiClient\test\ValueObject;

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
		$actual = $timeZone;
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
			[-720],
			[-660],
			[-600],
			[-540],
			[-480],
			[-420],
			[-360],
			[-300],
			[-240],
			[-210],
			[-180],
			[-120],
			[-60],
			[0],
			[60],
			[120],
			[180],
			[210],
			[240],
			[270],
			[300],
			[330],
			[345],
			[360],
			[420],
			[480],
			[540],
			[570],
			[600],
			[660],
			[720],
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
			[-721],
			[-6602],
			[-603],
			[-544],
			[-4805],
			[-425],
			[-3633],
			[-3],
			[-2440],
			[601],
			[1202],
			[1],
		];
	}
}
