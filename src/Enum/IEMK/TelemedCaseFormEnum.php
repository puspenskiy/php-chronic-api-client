<?php

namespace DocDoc\RgsApiClient\Enum\IEMK;

use DocDoc\RgsApiClient\Enum\AbstractBaseEnum;

/**
 * Классификация сервиса ЕГИСЗ ИЭМК.
 * Форма телемедицинской консультации (Справочник OID: 1.2.643.2.69.1.1.1.54)
 */
class TelemedCaseFormEnum extends AbstractBaseEnum
{
    public const ROUTINE = 1;
    public const URGENT = 2;
    public const  EMERGENCY = 3;
}
