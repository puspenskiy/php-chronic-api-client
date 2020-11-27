<?php

namespace DocDoc\RgsApiClient\Enum\IEMK;

use DocDoc\RgsApiClient\Enum\AbstractBaseEnum;

/**
 * Классификация сервиса ЕГИСЗ ИЭМК.
 * Код уровня конфиденциальности по региональному справочнику (Cправочник OID: 1.2.643.2.69.1.1.1.90)
 */
class ConfidentialityEnum extends AbstractBaseEnum
{
    public const UNLIMITED = 1;
    public const LIMITED = 2;
    public const SPECIAL_RESTRICTIONS = 3;
}
