<?php

namespace DocDoc\RgsApiClient\test\ValueObject;

use DocDoc\RgsApiClient\Dto\MetricDTO;
use DocDoc\RgsApiClient\Dto\MetricRangeDTO;
use DocDoc\RgsApiClient\Dto\MetricsDTO;
use DocDoc\RgsApiClient\Dto\MetricsRangeDTO;
use DocDoc\RgsApiClient\Dto\RgsApiParamsInterface;
use DocDoc\RgsApiClient\Exception\BadRequestRgsException;
use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\MetricsRgsClient;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @coversDefaultClass \DocDoc\RgsApiClient\MetricsRgsClient
 */
class MetricsRgsClientTest extends TestCase
{
	/** @var MetricsRgsClient */
	private $client;

	/**
	 * @inheritDoc
	 */
	public function setUp(): void
	{
		parent::setUp();
		$rgsApiParams = $this->createMock(RgsApiParamsInterface::class);
		// Mock server Apiary
		$rgsApiParams->method('getHost')->willReturn('https://private-63631f-chronicmonitor.apiary-mock.com/');
		$rgsApiParams->method('getPartnerId')->willReturn(241);

		$this->client = new MetricsRgsClient(
			new Client(),
			$rgsApiParams,
			$this->createMock(LoggerInterface::class)
		);
	}

	/**
	 * Тест отправки запроса на мок сервер Apiary
	 * Проверяется ответ на соответствие запросу.
	 *
	 * @covers ::getMetrics
	 *
	 * @param string $json
	 *
	 * @dataProvider dataProviderGet
	 *
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function testGet(string $json): void
	{
		$jsonMetricsObject = json_decode($json, true);
		$response = $this->client->getMetrics(1);
		$this->assertEquals(json_decode($response->getBody()->getContents(), true), $jsonMetricsObject);
	}

	/**
	 * @covers ::createMetrics
	 *
	 * @param string $requestData
	 * @param string $expectedResponseData
	 *
	 * @throws
	 * @dataProvider createDataProvider
	 */
	public function testCreate(string $requestData, string $expectedResponseData): void
	{
		$metricsDto = $this->buildMetricsDTO(json_decode($requestData, false));
		$response = $this->client->createMetrics($metricsDto);
		$this->assertEquals(
			json_decode($response->getBody()->getContents(), true),
			json_decode($expectedResponseData, true)
		);
	}

	/**
	 * @covers ::getMetricsLast
	 * @param string $expectedResponseData
	 *
	 * @throws
	 * @dataProvider dataProviderGetLast
	 */
	public function testGetLast(string $expectedResponseData): void
	{
		$response = $this->client->getMetricsLast(1);
		$this->assertEquals(
			json_decode($response->getBody()->getContents(), true),
			json_decode($expectedResponseData, true)
		);
	}

	/**
	 * @covers ::updateMetricsRanges
	 * @dataProvider dataProviderUpdateMetricsRanges
	 *
	 * @param string $requestData
	 * @param string $expectedResponseData
	 *
	 * @throws
	 */
	public function testUpdateRangeMetrics(string $requestData, string $expectedResponseData): void
	{
		$metricsRange = $this->buildMetricsRangeDTO(json_decode($requestData, false));
		$response = $this->client->updateMetricsRanges($metricsRange);
		$this->assertEquals(
			json_decode($response->getBody()->getContents(), true),
			json_decode($expectedResponseData, true)
		);
	}

	/**
	 * @inheritDoc
	 */
	public function createDataProvider(): array
	{
		return [
			[
				'{
                   "values": [
                     {
                       "key": "sys",
                       "value": "120"
                     }
                   ],
                   "source": "telemed",
                   "date": "1990-03-27",
                   "time": "00:30:00.000Z"
                 }',
				'[
                   {
                     "name": "Систола",
                     "key": "sys",
                     "value": "120",
                     "parentName": "Артериальное давление",
                     "parentKey": "ad",
                     "measurement": "мм рт. ст."
                   }
                 ]'
			]
		];
	}

	/**
	 * @inheritDoc
	 */
	public function dataProviderGet(): array
	{
		return [
			[
				'[
                   {
                     "parentName": "Артериальное давление",
                     "parentKey": "ad",
                     "name": "Систола",
                     "measurement": "мм рт. ст.",
                     "key": "sys",
                     "values": [
                       {
                         "value": "10",
                         "datetime": "2020-05-13T05:57:43.03Z",
                         "minValue": "8",
                         "maxValue": "12"
                       }
                     ]
                   }
                  ]'
			]
		];
	}

	/**
	 * @inheritDoc
	 */
	public function dataProviderGetLast(): array
	{
		return [
			[
				'[
                  {
                    "name": "Систола",
                    "key": "sys",
                    "value": "120",
                    "parentName": "Артериальное давление",
                    "parentKey": "ad",
                    "measurement": "мм рт. ст."
                  }
                 ]'
			]
		];
	}

	/**
	 * @inheritDoc
	 */
	public function dataProviderUpdateMetricsRanges(): array
	{
		return [
			[
				'{
                    "key": "sys",
                    "minValue": "60",
                    "maxValue": "120"
                   }',
				'{
                   "id": -100000000,
                   "category": {
                     "name": "Диабетик",
                     "key": "diabetic"
                   },
                   "firstName": "Иван",
                   "patronymic": "Иванов",
                   "phone": "+7 (904) 999-99-99",
                   "externalId": -100000000,
                   "active": true,
                   "monitoringEnabled": true,
                   "metadata": {
                     "productId": 13,
                     "contractId": 10293
                   },
                   "metricsRanges": [
                     {
                       "key": "sys",
                       "name": "Систола",
                       "parentKey": "ad",
                       "minValue": "60",
                       "maxValue": "120"
                     }
                   ],
                   "timezone": "+02:00"
                  }'
			]
		];
	}

	/**
	 * @param \stdClass $requestData - данные для запроса создания.
	 *
	 * @return MetricsDTO
	 * @throws \Exception
	 */
	private function buildMetricsDTO(\stdClass $requestData): MetricsDTO
	{
		$metrics = new MetricsDTO(1);
		$metric = new MetricDTO();
		$metric->setDateTime(new \DateTimeImmutable($requestData->date . ' ' . $requestData->time));
		$metric->setSource($requestData->source);
		$metric->setValues(
			[
				'key' => $requestData->values[0]->key,
				'value' => $requestData->values[0]->value,
			]
		);
		$metrics->addMetric($metric);
		return $metrics;
	}

	/**
	 * @param \stdClass $requestData - данные для запроса создания.
	 *
	 * @return MetricsRangeDTO
	 * @throws \Exception
	 */
	private function buildMetricsRangeDTO(\stdClass $requestData): MetricsRangeDTO
	{
		$metricsRange = new MetricsRangeDTO(1);
		$metricRange = new MetricRangeDTO();
		$metricRange->setKey($requestData->key);
		$metricRange->setMaxValue($requestData->maxValue);
		$metricRange->setMinValue($requestData->minValue);
		$metricsRange->addMetricRange($metricRange);
		return $metricsRange;
	}
}

