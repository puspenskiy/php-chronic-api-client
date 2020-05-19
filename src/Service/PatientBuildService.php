<?php

namespace DocDoc\RgsApiClient\Service;

use DocDoc\RgsApiClient\ValueObject\Patient\MetaData;
use DocDoc\RgsApiClient\ValueObject\Patient\Patient;
use DocDoc\RgsApiClient\ValueObject\Patient\TimeZone;

/**
 * Сервис создания объекта пациента из json представления.
 */
class PatientBuildService
{
	/**
	 * @param string $json
	 *
	 * @return Patient
	 * @throws \DocDoc\RgsApiClient\Exception\ValidationException
	 * @throws \Exception
	 */
	public function buildAsJson(string $json): Patient
	{
		$jsonPatientObject = json_decode($json, false);
		$patient = new Patient();
		$patient->setCategoryKey($jsonPatientObject->category->key);
		$patient->setFirstName($jsonPatientObject->firstName);
		$patient->setPhone($jsonPatientObject->phone);
		$patient->setPatronymic($jsonPatientObject->patronymic);
		$patient->setExternalId($jsonPatientObject->externalId);
		if ($jsonPatientObject->active === false) {
			$patient->deactivate();
		}

		if ($jsonPatientObject->monitoringEnabled === false) {
			$patient->monitoringDisabled();
		}

		$patient->setMetadata(
			new MetaData($jsonPatientObject->metadata->productId, $jsonPatientObject->metadata->contractId)
		);

		$patient->setMetricsRanges($jsonPatientObject->metricsRanges);
		try {
			// Когда поле строка '+00:00';
			if (preg_match('/^([+-](?:2[0-3]|[01][0-9]):[0-5][0-9])$/', $jsonPatientObject->timezone)) {
				$dateZeroTimeZone = new \DateTimeImmutable('now', new \DateTimeZone('+00:00'));
				$timeZonePatient = new \DateTimeZone($jsonPatientObject->timezone);
				$diff = $timeZonePatient->getOffset($dateZeroTimeZone) / 60;
				$timeZone = new TimeZone($diff);
			} else {
				//Когда поле число
				$timeZone = new TimeZone($jsonPatientObject->timezone);
			}
		} catch (\Exception $e) {
			$timeZone = new TimeZone(180); //MCK +03:00;
		}
		$patient->setTimezone($timeZone);
		return $patient;
	}
}
