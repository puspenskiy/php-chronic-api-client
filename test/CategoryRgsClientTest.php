<?php

namespace DocDoc\RgsApiClient\test;

use DocDoc\RgsApiClient\CategoryRgsClient;
use DocDoc\RgsApiClient\Dto\RgsApiParamsInterface;
use DocDoc\RgsApiClient\Enum\CategoryEnum;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @coversDefaultClass \DocDoc\RgsApiClient\CategoryRgsClient
 */
class CategoryRgsClientTest extends TestCase
{
	/** @var CategoryRgsClient */
	private $client;

	public function setUp(): void
	{
		parent::setUp();
		$rgsApiParams = $this->createMock(RgsApiParamsInterface::class);
		// Mock server Apiary
		$rgsApiParams->method('getHost')->willReturn('https://private-63631f-chronicmonitor.apiary-mock.com/');
		$rgsApiParams->method('getPartnerId')->willReturn(241);

		$this->client = new CategoryRgsClient(
			new Client(),
			$rgsApiParams,
			$this->createMock(LoggerInterface::class)
		);
	}

	/**
	 * @covers ::getForm
	 * @dataProvider dataProvider
	 *
	 * @param string $expectedResponseData
	 *
	 * @throws \DocDoc\RgsApiClient\Exception\BadRequestRgsException
	 * @throws \DocDoc\RgsApiClient\Exception\BaseRgsException
	 */
	public function testGetForm(string $expectedResponseData): void
	{
		$expectedResponseDataObject = json_decode($expectedResponseData, true);
		$response = $this->client->getForm(CategoryEnum::COVID);

		self::assertEquals(json_decode($response->getBody()->getContents(), true), $expectedResponseDataObject);
	}

	/**
	 * @covers ::getFormRanges
	 * @dataProvider dataProvider
	 *
	 * @param string $expectedResponseData
	 *
	 * @throws
	 */
	public function testGetFormRanges(string $expectedResponseData): void
	{
		$expectedResponseDataObject = json_decode($expectedResponseData, true);
		$response = $this->client->getFormRanges(CategoryEnum::COVID);

		self::assertEquals(json_decode($response->getBody()->getContents(), true), $expectedResponseDataObject);
	}

	/**
	 * @inheritDoc
	 */
	public function dataProvider(): array
	{
		return [
			[
				'{
                   "items": [
                     {
                       "name": "SYS (верхнее)",
                       "key": "sys",
                       "placeholder": "120 мм рт. ст.",
                       "validation": {
                         "minvalue": "30",
                         "maxvalue": "300"
                       },
                       "options": {
                         "before_eat": "До еды",
                         "after_eat": "После еды"
                       }
                     }
                   ],
                   "errorMessages": {
                     "required": "Поле %s обязательно для заполнения",
                     "minValue": "Значение поля %s, не должно быть меньше %s"
                   }
                 }'
			]
		];
	}
}
