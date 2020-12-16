<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\Enum\IEMK\MimeTypeEnum;
use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use DocDoc\RgsApiClient\ValueObject\IEMK\IemkValueObjectTrait;
use JsonSerializable;

/**
 * Неструктурированное (бинарное) содержания документа.
 */
class DocumentAttachment extends AbstractValidateValueObject implements JsonSerializable
{
    use IemkValueObjectTrait;

    /**
     * Данные вложения (текст, pdf, html,xml) в формате base64binary
     * Рекомендуется для обмена данными использовать формат PDF/A-1
     *
     * @var string
     */
    private $data;

    /**
     * Тип документа.
     * Текущая реализация поддерживает только 'application/pdf'
     *
     * @var string
     */
    private $mimeType;

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
        return $this->data;
    }

    /**
     * @param string $data
     *
     * @return DocumentAttachment
     */
    public function setData(string $data): DocumentAttachment
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     *
     * @return DocumentAttachment
     */
    public function setMimeType(string $mimeType): DocumentAttachment
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Проверка валидности значений объекта.
     */
    public function validate(): bool
    {
        parent::validate();
        if ($this->mimeType !== MimeTypeEnum::PDF) {
            $this->errors['mimeType'] = 'Недопустимое значение mimetype. Для текущей реализации доступен только "'. MimeTypeEnum::PDF . '"';
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
            $this->fields = ['data', 'mimeType'];
        }

        return $this->fields;
    }
}
