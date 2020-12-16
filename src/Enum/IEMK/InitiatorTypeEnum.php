<?php

namespace DocDoc\RgsApiClient\Enum\IEMK;

use DocDoc\RgsApiClient\Enum\AbstractBaseEnum;

/**
 * Классификация сервиса ЕГИСЗ ИЭМК.
 * Идентификатор типа инициатора проведения телемедицинской консультации.
 * Справочник OID: 1.2.643.2.69.1.1.1.129
 */
class InitiatorTypeEnum extends AbstractBaseEnum
{
    public const PATIENT = 1;
    public const LEGAL_REPRESENTATIVE = 2;
    public const ATTENDING_DOCTOR = 3;
}
