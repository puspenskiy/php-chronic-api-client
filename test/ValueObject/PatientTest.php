<?php

namespace DocDoc\RgsApiClient\test\ValueObject;

use DocDoc\RgsApiClient\Enum\RobotTypeEnum;
use DocDoc\RgsApiClient\Exception\ValidationException;
use DocDoc\RgsApiClient\ValueObject\Patient\MetaData;
use DocDoc\RgsApiClient\ValueObject\Patient\Patient;
use DocDoc\RgsApiClient\ValueObject\Patient\TimeZone;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DocDoc\RgsApiClient\ValueObject\Patient\Patient
 */
class PatientTest extends TestCase
{
	/**
	 * Тест на удачное преобразование объекта в json
	 *
	 * @dataProvider successJsonSerializeDataProvider
	 *
	 * @covers ::jsonSerialize
	 * @param string $jsonPatient
	 *
	 * @throws ValidationException
	 */
	public function testSuccessJsonSerialize(string $jsonPatient): void
	{
		$jsonPatientObject = json_decode($jsonPatient, false);
		$patient = new Patient();
		$patient->setCategoryKey($jsonPatientObject->categoryKey);
		$patient->setFirstName($jsonPatientObject->firstName);
		$patient->setPhone($jsonPatientObject->phone);
		$patient->setPatronymic($jsonPatientObject->patronymic ?? null);
		$patient->setExternalId($jsonPatientObject->externalId);
		$patient->setRobotType($jsonPatientObject->robotType);
		if ($jsonPatientObject->active === false) {
			$patient->deactivate();
		}

		if ($jsonPatientObject->monitoringEnabled === false) {
			$patient->monitoringDisabled();
		}

		$patient->setMetadata(
			new MetaData($jsonPatientObject->metadata->productId, $jsonPatientObject->metadata->contractId)
		);
		$patient->setTimezone(new TimeZone(120));
		$actual = json_encode($patient);
		//сброс красивого форматирования
		$jsonPatientObject->timezone = $patient->getTimezone()->jsonSerialize();
		unset($jsonPatientObject->metricsRanges);
		$expected = json_encode($jsonPatientObject);
		self::assertEquals(
			$expected,
			$actual,
			'Представление объекта Пациента не соответствует ожидаемому'
		);
	}

	/**
	 * Тест на не удачное преобразование объекта в json
	 * Не наполняем объект и пытаемся преобразовать в json
	 *
	 * @dataProvider failJsonSerializeDataProvider
	 *
	 * @covers ::jsonSerialize
	 * @param string $jsonPatient
	 *
	 */
	public function testFailJsonSerialize(string $jsonPatient): void
	{
		$this->expectException(ValidationException::class);
		$jsonPatientObject = json_decode($jsonPatient, false);
		$patient = new Patient();
		$patient->setCategoryKey($jsonPatientObject->categoryKey);

		$result = json_encode($patient);
		unset($result);
	}

	/**
	 * Проверка допустимых значений типа робота для обзвона.
	 *
	 * @param string|null $robotType
	 * @param             $expectValidateResult
	 *
	 * @dataProvider robotTypeValidationDataProvider
	 */
	public function testValidateRobotType(?string $robotType, bool $expectValidateResult): void
	{
		$patient = new Patient();
		$patient->setRobotType($robotType);
		$patient->validate(); //false т.к остальное не заполнено.
		$errors = $patient->getErrors();
		self::assertEquals(
			$expectValidateResult,
			(isset($errors['robotType']) === false), //Наличие ошибки = провал валидации.
			'Валидация ' . $robotType . ' прошла не так как ожидалось'
		);
	}

	public function robotTypeValidationDataProvider(): array
	{
		$result = [];
		foreach (RobotTypeEnum::getAllValues() as $value) {
			$result[] = [$value, true];
		}
		$result[] = ['не_существует_такой_робот', false];
		return $result;
	}

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
                    "monitoringEnabled": true,
                    "metricsRanges":[],
                    "robotType":"robovoice"
                }'
			],
			[
				'{
                    "categoryKey": "hypertonic",
                    "firstName": "Иван",
                    "patronymic": "Иванов",
                    "phone": "+7 (904) 999-99-99",
                    "externalId": -100000000,
                    "metadata": {
                        "productId": 13,
                        "contractId": 10293
                    },
                    "timezone": "+02:00",
                    "active": false,
                    "monitoringEnabled": false,
                    "metricsRanges":[],
                    "robotType":"robovoice"
                }'
			],
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
                    "timezone": "+02:00",
                    "active": false,
                    "monitoringEnabled": false,
                    "metricsRanges":[],
                    "robotType":"robovoice"
                }'
			],
			[
				'{
                    "categoryKey": "diabetic",
                    "firstName": "Иван",
                    "phone": "+7 (904) 999-99-99",
                    "externalId": -100000000,
                    "metadata": {
                        "productId": 13,
                        "contractId": 10293
                    },
                    "timezone": "+02:00",
                    "active": false,
                    "monitoringEnabled": false,
                    "metricsRanges":[],
                    "robotType":"robovoice"
                }'
			],
		];
	}

	public function failJsonSerializeDataProvider(): array
	{
		return [
			[
				'{
                    "categoryKey": "Не известный тип"
                }'
			],
			[
				'{
                    "categoryKey": "hypertonic"
                }'
			],
		];
	}
}
