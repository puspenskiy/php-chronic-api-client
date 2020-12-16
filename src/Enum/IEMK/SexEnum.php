<?php

namespace DocDoc\RgsApiClient\Enum\IEMK;

use DocDoc\RgsApiClient\Enum\AbstractBaseEnum;

/**
 * Пол пациента классификация сервиса ЕГИСЗ ИЭМК
 */
class SexEnum extends AbstractBaseEnum
{
    public const DEFAULT = 0;
    public const MAN = 1;
    public const WOMEN = 2;
}
