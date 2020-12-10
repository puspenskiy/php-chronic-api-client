<?php

namespace DocDoc\RgsApiClient\test;

use DocDoc\RgsApiClient\Dto\RgsApiParamsInterface;
use DocDoc\RgsApiClient\Exception\InternalErrorRgsException;
use DocDoc\RgsApiClient\Exception\BaseRgsException;
use DocDoc\RgsApiClient\Exception\ValidationException;
use DocDoc\RgsApiClient\PatientRgsClient;
use DocDoc\RgsApiClient\ValueObject\Patient\MetaData;
use DocDoc\RgsApiClient\ValueObject\Patient\Patient;
use DocDoc\RgsApiClient\ValueObject\Patient\TimeZone;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
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
			$this->createMock(LoggerInterface::class)
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
	 * @throws InternalErrorRgsException
	 * @throws BaseRgsException
	 * @throws ValidationException
	 */
	public function testCreate(string $jsonPatient): void
	{
		$patient = $this->getPatientObject($jsonPatient);

		$patientResponse = $this->client->createPatient($patient);
		$this->checkPatient($patient, $patientResponse);
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
	 * @throws InternalErrorRgsException
	 * @throws BaseRgsException
	 * @throws ValidationException
	 */
	public function testUpdate(string $jsonPatient): void
	{
		$patient = $this->getPatientObject($jsonPatient);
		$patientResponse = $this->client->updatePatient($patient);

		$this->checkPatient($patient, $patientResponse);
	}

	/**
	 * @dataProvider getPatientDataProvider
	 *
	 * @param $extendedJson
	 * @covers ::getPatient
	 *
	 * @throws InternalErrorRgsException
	 * @throws BaseRgsException
	 */
	public function testGetPatient(string $extendedJson): void
	{
		$response = $this->client->getPatient(100);
		$this->assertFieldsResponse($response, $extendedJson);
	}

	/**
	 * Набор утверждений сравнивающих поступивший и ожидаемый ответ.
	 *
	 * @param ResponseInterface $response
	 * @param string            $extendedJson
	 */
	protected function assertFieldsResponse(ResponseInterface $response, string $extendedJson): void
	{
		$jsonPatientObject = json_decode($extendedJson, false);
		$expectedObject = json_decode($response->getBody()->getContents(), false);
		$fields = get_object_vars($jsonPatientObject);
		//этих полей в ответе нет, все остальные должны совпадать
		unset($fields['categoryKey']);
		unset($fields['robotType']); //TODO  22.02.2020 метод и формат ответа еще не описан в документации.
		foreach ($fields as $field => $value) {
			self::assertEquals($expectedObject->$field, $value);
		}
	}

	/**
	 * @dataProvider getPatientDataProvider
	 * @covers ::activate
	 *
	 * @param string $extendedJson
	 *
	 * @throws InternalErrorRgsException
	 * @throws BaseRgsException
	 */
	public function testActivate(string $extendedJson): void
	{
		$response = $this->client->activate(100);
		$this->assertFieldsResponse($response, $extendedJson);
	}

	/**
	 * @dataProvider getPatientDataProvider
	 * @covers ::inactivate
	 *
	 * @param string $extendedJson
	 *
	 * @throws InternalErrorRgsException
	 * @throws BaseRgsException
	 */
	public function testInactivate(string $extendedJson): void
	{
		$response = $this->client->inactivate(100, 1);
		$this->assertFieldsResponse($response, $extendedJson);
	}

    /**
     * @covers ::enableMonitoring
     *
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     */
	public function testEnableMonitoring(): void
    {
        $response = $this->client->enableMonitoring(100);
        $this->assertFieldsResponse($response, '');
    }

    /**
     * @covers ::disableMonitoring
     *
     * @throws InternalErrorRgsException
     * @throws BaseRgsException
     */
    public function testDisableMonitoring(): void
    {
        $response = $this->client->disableMonitoring(100);
        $this->assertFieldsResponse($response, '');
    }

	public function successJsonSerializeDataProvider(): array
	{
		return [
			[
				'{
                    "categoryKey": "diabetic",
                    "firstName": "Иван",
                    "patronymic": "Иванов",
                    "phone": "+7 (904) 999-99-99",
                    "externalId": -100000000,
                    "metadata": {
                        "productId": 13,
                        "contractId": 10293
                    },
                    "timezone": 120,
                    "active": true,
                    "monitoringEnabled": true,
                    "robotType":"robovoice"
                }'
			],
		];
	}

	public function getPatientDataProvider(): array
	{
		return [
			[
				'{
                    "id": -100000000,
                    "categoryKey": "diabetic",
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
                    "timezone": "+02:00",
                    "robotType":"robovoice"
                  }'
			]
		];
	}

	private function checkPatient(Patient $requestPatient, ResponseInterface $responsePatient): void
	{
		$responsePatient = json_decode($responsePatient->getBody()->getContents(), true);

		self::assertEquals($responsePatient['category']['key'], $requestPatient->getCategoryKey());
		self::assertEquals($responsePatient['firstName'], $requestPatient->getFirstName());
		self::assertEquals($responsePatient['phone'], $requestPatient->getPhone());
		self::assertEquals($responsePatient['externalId'], $requestPatient->getExternalId());
		self::assertEquals($responsePatient['patronymic'], $requestPatient->getPatronymic());
		self::assertEquals($responsePatient['active'], $requestPatient->isActive());
		self::assertEquals($responsePatient['monitoringEnabled'], $requestPatient->isMonitoringEnabled());
		//self::assertEquals($responsePatient['robotType'], $requestPatient->getRobotType()); //TODO на момент 22.02.2020 свойство не описано документации.
	}

	/**
	 * @param string $jsonPatient
	 *
	 * @return Patient
	 * @throws ValidationException
	 */
	private function getPatientObject(string $jsonPatient): Patient
	{
		$jsonPatientObject = json_decode($jsonPatient, false);
		$patient = new Patient();
		$patient->setCategoryKey($jsonPatientObject->categoryKey);
		$patient->setFirstName($jsonPatientObject->firstName);
		$patient->setPhone($jsonPatientObject->phone);
		$patient->setPatronymic($jsonPatientObject->patronymic);
		$patient->setExternalId($jsonPatientObject->externalId);
		$patient->setRobotType($jsonPatientObject->robotType);
		$patient->setMetadata(
			new MetaData($jsonPatientObject->metadata->productId, $jsonPatientObject->metadata->contractId)
		);
		$patient->setTimezone(new TimeZone($jsonPatientObject->timezone));
		return $patient;
	}
}
