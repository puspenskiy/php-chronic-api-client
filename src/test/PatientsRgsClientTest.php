<?php

namespace DocDoc\RgsApiClient\test\ValueObject;

use DocDoc\RgsApiClient\Dto\RgsApiParamsInterface;
use DocDoc\RgsApiClient\Enum\CategoryEnum;
use DocDoc\RgsApiClient\Exception\BadRequestRgsException;
use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\PatientRgsClient;
use DocDoc\RgsApiClient\Service\PatientBuildService;
use DocDoc\RgsApiClient\ValueObject\Patient\MetaData;
use DocDoc\RgsApiClient\ValueObject\Patient\Patient;
use DocDoc\RgsApiClient\ValueObject\Patient\TimeZone;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @coversDefaultClass \DocDoc\RgsApiClient\PatientRgsClient
 */
class PatientsRgsClientTest extends TestCase
{
	/** @var PatientRgsClient */
	private $client;

	public function setUp(): void
	{
		parent::setUp();
		$rgsApiParams = $this->createMock(RgsApiParamsInterface::class);
		// Mock server Apiary
		$rgsApiParams->method('getHost')->willReturn('https://private-63631f-chronicmonitor.apiary-mock.com/');
		$rgsApiParams->method('getPartnerId')->willReturn(241);

		$this->client = new PatientRgsClient(
			new Client(),
			$rgsApiParams,
			$this->createMock(LoggerInterface::class),
			new PatientBuildService()
		);
	}

	/**
	 * Тест отправки запроса на мок сервер Apiary
	 * Проверяется ответ на  соответствие запросу.
	 *
	 * @covers ::createPatient
	 *
	 * @param string $jsonPatient
	 *
	 * @dataProvider successJsonSerializeDataProvider
	 *
	 * @throws \DocDoc\RgsApiClient\Exception\ValidationException
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function testCreate(string $jsonPatient): void
	{
		$jsonPatientObject = json_decode($jsonPatient, false);

		$patient = new Patient();
		$patient->setCategoryKey($jsonPatientObject->categoryKey);
		$patient->setFirstName($jsonPatientObject->firstName);
		$patient->setPhone($jsonPatientObject->phone);
		$patient->setPatronymic($jsonPatientObject->patronymic);
		$patient->setExternalId($jsonPatientObject->externalId);

		$patient->setMetadata(
			new MetaData($jsonPatientObject->metadata->productId, $jsonPatientObject->metadata->contractId)
		);
		$patient->setTimezone(new TimeZone($jsonPatientObject->timezone));

		$patientResponse = $this->client->createPatient($patient);
		//В данный момент мок сервер отдаёт ответ с полями которые не  могут быть у только что созданного пациента.
		// и не отдаёт категорию пациента
		$patientResponse->setMetricsRanges([]);
		$patientResponse->setCategoryKey(CategoryEnum::COVID);
		$this->assertTrue($patientResponse->validate(), 'При создании пациента получен не валидный объект.');

		$this->assertEquals($patient, $patientResponse);
	}

	/**
	 * Тест отправки запроса на мок сервер Apiary
	 * Проверяется ответ на  соответствие запросу.
	 *
	 * @covers ::updatePatient
	 *
	 * @param string $jsonPatient
	 *
	 * @dataProvider successJsonSerializeDataProvider
	 *
	 * @throws \DocDoc\RgsApiClient\Exception\ValidationException
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function testUpdate(string $jsonPatient): void
	{
		$jsonPatientObject = json_decode($jsonPatient, false);

		$patient = new Patient();
		$patient->setCategoryKey($jsonPatientObject->categoryKey);
		$patient->setFirstName($jsonPatientObject->firstName);
		$patient->setPhone($jsonPatientObject->phone);
		$patient->setPatronymic($jsonPatientObject->patronymic);
		$patient->setExternalId($jsonPatientObject->externalId);

		$patient->setMetadata(
			new MetaData($jsonPatientObject->metadata->productId, $jsonPatientObject->metadata->contractId)
		);
		$patient->setTimezone(new TimeZone($jsonPatientObject->timezone));

		$patientResponse = $this->client->updatePatient($patient);
		//В данный момент мок сервер отдаёт ответ с полями которые не  могут быть у только что созданного пациента.
		// и не отдаёт категорию пациента
		$patientResponse->setMetricsRanges([]);
		$patientResponse->setCategoryKey(CategoryEnum::COVID);
		$this->assertTrue($patientResponse->validate(), 'При обновлении пациента получен не валидный объект.');
		$this->assertEquals($patient, $patientResponse);
	}

	/**
	 * @dataProvider getPatientDataProvider
	 *
	 * @param $jsonPatient
	 * @covers ::getPatient
	 *
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function testGetPatient($jsonPatient): void
	{
		$jsonPatientObject = json_decode($jsonPatient, false);

		$patient = $this->client->getPatient(100);
		//В Моке АПИ не корректный ответ  поправим в тесте.
		$patient->setCategoryKey(CategoryEnum::COVID);
		$expectedObject = json_decode(json_encode($patient), false);
		$fields = get_object_vars($jsonPatientObject);
		//этих полей в ответе нет, все остальные должны совпадать
		unset($fields['categoryKey'], $fields['id']);

		foreach ($fields as $field => $value) {
			$this->assertEquals($expectedObject->$field, $value);
		}
	}

	/**
	 * @dataProvider getPatientDataProvider
	 * @covers ::activate
	 *
	 * @param $jsonPatient
	 *
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function testActivate($jsonPatient): void
	{
		$jsonPatientObject = json_decode($jsonPatient, false);

		$patient = $this->client->activate(100);
		//В Моке АПИ не корректный ответ  поправим в тесте.
		$patient->setCategoryKey(CategoryEnum::COVID);
		$expectedObject = json_decode(json_encode($patient), false);
		$fields = get_object_vars($jsonPatientObject);
		//этих полей в ответе нет, все остальные должны совпадать
		unset($fields['categoryKey'], $fields['id']);

		foreach ($fields as $field => $value) {
			$this->assertEquals($expectedObject->$field, $value);
		}
	}

	/**
	 * @dataProvider getPatientDataProvider
	 * @covers ::inactivate
	 *
	 * @param $jsonPatient
	 *
	 * @throws BadRequestRgsException
	 * @throws BaseRgsException
	 */
	public function testInactivate($jsonPatient): void
	{
		$jsonPatientObject = json_decode($jsonPatient, false);

		$patient = $this->client->activate(100);
		//В Моке АПИ не корректный ответ  поправим в тесте.
		$patient->setCategoryKey(CategoryEnum::COVID);
		$expectedObject = json_decode(json_encode($patient), false);
		$fields = get_object_vars($jsonPatientObject);
		//этих полей в ответе нет, все остальные должны совпадать
		unset($fields['categoryKey'], $fields['id']);

		foreach ($fields as $field => $value) {
			$this->assertEquals($expectedObject->$field, $value);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function successJsonSerializeDataProvider(): array
	{
		return [
			[
				'{
                    "categoryKey": "covid",
                    "firstName": "Иван",
                    "patronymic": "Иванов",
                    "phone": "+7 (904) 999-99-99",
                    "externalId": -100000000,
                    "metadata": {
                        "productId": 13,
                        "contractId": 10293
                    },
                    "timezone": "+02:00",
                    "active": true,
                    "monitoringEnabled": true
                }'
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getPatientDataProvider(): array
	{
		return [
			[
				'{
                    "id": -100000000,
                    "categoryKey": "covid",
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
                        "name": "Пульс",
                        "key": "pulse",
                        "value": [
                          {
                            "sistola": "120",
                            "diastola": "80"
                          }
                        ],
                        "propertiesLabel": [
                          {
                            "sistola": "Систола",
                            "diastola": "Диастола"
                          }
                        ]
                      }
                    ],
                    "timezone": "+02:00"
                  }'
			]
		];
	}
}
