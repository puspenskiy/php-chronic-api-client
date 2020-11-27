<?php

namespace DocDoc\RgsApiClient\Enum\IEMK;

use DocDoc\RgsApiClient\Enum\AbstractBaseEnum;

/**
 * Классификация сервиса ЕГИСЗ ИЭМК.
 * Цель телемедицинской консультации (Cправочник OID: 1.2.643.2.69.1.1.1.128)
 */
class TelemedCaseGoalEnum extends AbstractBaseEnum
{
    public const DETERMINATION_OR_CONFIRMATION_OF_THE_DIAGNOSIS = 1;
    public const DETERMINATION_OR_CONFIRMATION_OF_TREATMENT_TACTICS_AND_DIAGNOSTIC_METHODS = 2;
    public const COORDINATION_OF_THE_PATIENT_REFERRAL_TO_THE_MEDICAL_ORGANIZATION = 3;
    public const COORDINATION_OF_THE_TRANSFER_OF_THE_PATIENT_TO_A_MEDICAL_ORGANIZATION = 4;
    public const INTERPRETATION_OF_DIAGNOSTIC_TEST_RESULTS = 5;
    public const OBTAINING_EXPERT_OPINION_ON_THE_RESULT_OF_A_DIAGNOSTIC_STUDY = 6;
    public const ANALYSIS_OF_THE_CLINICAL_CASE = 7;
    public const REMOTE_MONITORING_OF_THE_PATIENT = 8;
    public const OTHER = 9;
}
