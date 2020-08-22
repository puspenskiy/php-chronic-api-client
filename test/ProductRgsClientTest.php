<?php

namespace DocDoc\RgsApiClient\test;

use DocDoc\RgsApiClient\CategoryRgsClient;
use DocDoc\RgsApiClient\Dto\RgsApiParamsInterface;
use DocDoc\RgsApiClient\Enum\RobotTypeEnum;
use DocDoc\RgsApiClient\ProductRgsClient;
use DocDoc\RgsApiClient\ValueObject\Product\Product;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @coversDefaultClass \DocDoc\RgsApiClient\ProductRgsClient
 * @
 */
class ProductRgsClientTest extends TestCase
{
	/** @var ProductRgsClient */
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
	 * @covers ::updateProduct
	 *
	 * @param string $expectedResponseData
	 *
	 * @throws \DocDoc\RgsApiClient\Exception\BadRequestRgsException
	 * @throws \DocDoc\RgsApiClient\Exception\BaseRgsException
	 * @dataProvider getProductDataProvider
	 */
	public function testUpdate(string $expectedResponseData): void
	{
		self::markTestIncomplete(
			'Этот тест ещё не реализован.'
		);
		$expectedResponseDataObject = json_decode($expectedResponseData, true);
		$product = new Product(2017, RobotTypeEnum::ROBOVOICE);
		$response = $this->client->updateProduct($product);

		self::assertEquals(json_decode($response->getBody()->getContents(), true), $expectedResponseDataObject);
	}

	/**
	 * Данные продуктов для обновления и ожидания в мок апи методе.
	 *
	 * @return array <array<string>>
	 */
	public function getProductDataProvider(): array
	{
		return [
			[
				'{"на момент 22.02.2020 метод и формат ответа еще не описан в документации."}'
			]
		];
	}
}
