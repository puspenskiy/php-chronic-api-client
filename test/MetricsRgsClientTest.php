<?php

namespace DocDoc\RgsApiClient\test;

use DateTimeImmutable;
use DocDoc\RgsApiClient\Dto\DoctorCommentDto;
use DocDoc\RgsApiClient\Dto\MetricDTO;
use DocDoc\RgsApiClient\Dto\MetricRangeDTO;
use DocDoc\RgsApiClient\Dto\MetricsRangeDTO;
use DocDoc\RgsApiClient\Dto\RgsApiParamsInterface;
use DocDoc\RgsApiClient\Exception\InternalErrorRgsException;
use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\MetricsRgsClient;
use Exception;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use stdClass;

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
	 * @throws InternalErrorRgsException
	 * @throws BaseRgsException
	 */
	public function testGet(string $json): void
	{
		$jsonMetricsObject = json_decode($json, true);
		$response = $this->client->getMetrics(1);
		$responseArray = json_decode($response->getBody()->getContents(), true);
		self::assertArrayHasKey('datetime', $responseArray[0]['values'][0]);
		self::assertStringMatchesFormat('%d-%d-%dT%d:%d:%d.%dZ', $responseArray[0]['values'][0]['datetime']);
		unset($responseArray[0]['values'][0]['datetime'], $jsonMetricsObject[0]['values'][0]['datetime']);
		self::assertEquals($responseArray, $jsonMetricsObject);
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
		$metricsDto = $this->buildMetricDTO(json_decode($requestData, false));
		$response = $this->client->createMetrics($metricsDto);
		$expectedResponseDataArray = json_decode($expectedResponseData, true);
		$responseArray = json_decode($response->getBody()->getContents(), true);
		self::assertArrayHasKey('datetime', $responseArray['items'][0]);
		self::assertStringMatchesFormat('%d-%d-%dT%d:%d:%d.%dZ', $responseArray['items'][0]['datetime']);
		unset($responseArray['items'][0]['datetime'], $expectedResponseDataArray['items'][0]['datetime']);
		self::assertEquals(
			$responseArray,
			$expectedResponseDataArray
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
		$expectedResponseDataArray = json_decode($expectedResponseData, true);
		$responseArray = json_decode($response->getBody()->getContents(), true);
		self::assertArrayHasKey('datetime', $responseArray[0]);
		self::assertStringMatchesFormat('%d-%d-%dT%d:%d:%d.%dZ', $responseArray[0]['datetime']);
		unset($responseArray[0]['datetime'], $expectedResponseDataArray[0]['datetime']);
		self::assertEquals(
			$responseArray,
			$expectedResponseDataArray
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
		self::assertEquals(
			json_decode($response->getBody()->getContents(), true),
			json_decode($expectedResponseData, true)
		);
	}

    /**
     * @covers ::addDoctorComment
     *
     * @throws BaseRgsException
     * @throws InternalErrorRgsException
     * @throws \DocDoc\RgsApiClient\Exception\BadRequestRgsException
     */
    public function testAddDoctorComment(): void
    {
        $doctorComment = new DoctorCommentDto();
        $doctorComment->setDoctorComment('Комментарий');

        $response = $this->client->addDoctorComment(10, 20, $doctorComment);
        $this->assertEquals('', $response->getBody()->getContents());
        $this->assertEquals(201, $response->getStatusCode());
	}

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
				'{
                    "abnormal": false,
                    "items": [
                        {
                            "name": "Систола",
                            "key": "sys",
                            "value": "120",
                            "parentName": "Артериальное давление",
                            "parentKey": "ad",
                            "measurement": "мм рт. ст.",
                            "datetime": "2020-05-25T15:25:18.29Z"
                        }
                    ]
                }'
			]
		];
	}

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
                         "datetime": "2020-05-25T15:25:18.281Z",
                         "id": -100000000,
                         "minValue": "8",
                         "maxValue": "12"
                       }
                     ]
                   }
                  ]'
			]
		];
	}

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
                    "measurement": "мм рт. ст.",
                    "datetime": "2020-05-25T15:25:18.296Z"
                  }
                 ]'
			]
		];
	}

	public function dataProviderUpdateMetricsRanges(): array
	{
		return [
			[
				'{
                   "key": "pulse_max",
                   "value": "120"
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
	 * @param stdClass $requestData - данные для запроса создания.
	 *
	 * @return MetricDTO
	 * @throws Exception
	 */
	private function buildMetricDTO(stdClass $requestData): MetricDTO
	{
		$metric = new MetricDTO(1);
		$metric->setDateTime(new DateTimeImmutable($requestData->date . ' ' . $requestData->time));
		$metric->setSource($requestData->source);
		$metric->setValues(
			[
				'key' => $requestData->values[0]->key,
				'value' => $requestData->values[0]->value,
			]
		);
		return $metric;
	}

	/**
	 * @param stdClass $requestData - данные для запроса создания.
	 *
	 * @return MetricsRangeDTO
	 * @throws Exception
	 */
	private function buildMetricsRangeDTO(stdClass $requestData): MetricsRangeDTO
	{
		$metricsRange = new MetricsRangeDTO(1);
		$metricRange = new MetricRangeDTO();
		$metricRange->setKey($requestData->key);
		$metricRange->setValue($requestData->value);
		$metricsRange->addMetricRange($metricRange);
		return $metricsRange;
	}
}

