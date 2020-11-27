<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\Enum\IEMK\MimeTypeEnum;
use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use JsonSerializable;

/**
 * Неструктурированное (бинарное) содержания документа.
 */
class DocumentAttachment extends AbstractValidateValueObject implements JsonSerializable
{
    /**
     * Данные вложения (текст, pdf, html,xml) в формате base64binary
     * Рекомендуется для обмена данными использовать формат PDF/A-1
     *
     * @var string
     */
    private $Data;

    /**
     * Тип документа.
     * Текущая реализация поддерживает только 'application/pdf'
     *
     * @var string
     */
    private $MimeType;

    /**
     * Список ошибок валидации
     *
     * @return array <string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->Data;
    }

    /**
     * @param string $Data
     */
    public function setData(string $Data): void
    {
        $this->Data = $Data;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->MimeType;
    }

    /**
     * @param string $MimeType
     */
    public function setMimeType(string $MimeType): void
    {
        $this->MimeType = $MimeType;
    }

    /**
     * Проверка валидности значений объекта.
     */
    public function validate(): bool
    {
        parent::validate();
        if ($this->MimeType !== MimeTypeEnum::PDF) {
            $this->errors['MimeType'] = 'Недопустимое значение Mimetype. Для текущей реализации доступен только "application/pdf"';
        }

        return !(bool)$this->errors;
    }

    /**
     * @inheritDoc
     */
    protected function getRequiredFields(): array
    {
        return $this->getFields();
    }

    /**
     * @inheritDoc
     */
    protected function getFields(): array
    {
        if ($this->fields === null) {
            $this->fields = ['Data', 'MimeType'];
        }

        return $this->fields;
    }
}
