<?php

namespace DocDoc\RgsApiClient\Enum\IEMK;

use DocDoc\RgsApiClient\Enum\AbstractBaseEnum;

/**
 * Классификация сервиса ЕГИСЗ ИЭМК.
 * Идентификатор исхода заболевания (Справочник OID: 1.2.643.5.1.13.2.1.1.688)
 */
class CaseResultEnum extends AbstractBaseEnum
{
    public const RECOVERY = 1;
    public const IMPROVEMENT = 2;
    public const NO_CHANGE = 3;
    public const DETERIORATION = 4;
    public const HEALTHY = 5;
    public const DEATH = 6;
}
