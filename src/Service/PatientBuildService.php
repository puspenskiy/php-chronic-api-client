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

		$patient->setTimezone(new TimeZone($jsonPatientObject->timezone));
		return $patient;
	}
}
