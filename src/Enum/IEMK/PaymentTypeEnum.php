<?php

namespace DocDoc\RgsApiClient\Enum\IEMK;

use DocDoc\RgsApiClient\Enum\AbstractBaseEnum;

/**
 * Классификация сервиса ЕГИСЗ ИЭМК.
 * Идентификатор источника финансирования. (Cправочник OID: 1.2.643.2.69.1.1.1.32)
 */
class PaymentTypeEnum extends AbstractBaseEnum
{
    public const OMS = 1;
    public const BUDGET = 2;
    public const PAID_SERVICES = 3;
    public const DMS = 4;
    public const OWN_FUNDS = 5;
    public const OTHER = 6;
}
