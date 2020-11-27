<?php

namespace DocDoc\RgsApiClient\Enum\IEMK;

use DocDoc\RgsApiClient\Enum\AbstractBaseEnum;

/**
 * Классификация сервиса ЕГИСЗ ИЭМК
 * Тип документа
 */
class MimeTypeEnum  extends AbstractBaseEnum
{
    public const HTML = 'text/html';
    public const TEXT = 'text/plain';
    public const PDF = 'application/pdf';
    public const XML = 'text/xml';
}
