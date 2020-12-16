<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use DocDoc\RgsApiClient\ValueObject\IEMK\IemkValueObjectTrait;
use JsonSerializable;

/**
 * Объект базового типа Медицинские записи.
 * Реализован базовый подтип ConsultNote для передачи медицинских документов.
 * Описание: https://api.n3health.ru/docs.php?article=IEMKService#MedDocument
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания медицниских заключений по завершенному случаю обслуживания в сервисе ЕГИСЗ ИЭМК
 */
class MedRecord  extends AbstractValidateValueObject implements JsonSerializable
{
    use IemkValueObjectTrait;


    /**
     * Массив неструктурированного (бинарного) содержания документа
     * @var DocumentAttachment[]
     */
    private $attachments;

    /**
     * Сведения о лице, создавшем документ
     * @var MedicalStaff
     */
    private $author;

    /**
     * Дата создания документа
     * @var string
     */
    private $creationDate;

    /**
     * Заголовок документа (краткое описание)
     * @var string
     */
    private $header;

    /**
     * Идентификатор документа в системе-источнике (МИС)
     * @var string
     */
    private $idDocumentMis;

    /**
     * @return DocumentAttachment[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @param DocumentAttachment[] $attachments
     *
     * @return MedRecord
     */
    public function setAttachments(array $attachments): MedRecord
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @return MedicalStaff
     */
    public function getAuthor(): MedicalStaff
    {
        return $this->author;
    }

    /**
     * @param MedicalStaff $author
     *
     * @return MedRecord
     */
    public function setAuthor(MedicalStaff $author): MedRecord
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    /**
     * @param string $creationDate
     *
     * @return MedRecord
     */
    public function setCreationDate(string $creationDate): MedRecord
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @param string $header
     *
     * @return MedRecord
     */
    public function setHeader(string $header): MedRecord
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdDocumentMis(): string
    {
        return $this->idDocumentMis;
    }

    /**
     * @param string $idDocumentMis
     *
     * @return MedRecord
     */
    public function setIdDocumentMis(string $idDocumentMis): MedRecord
    {
        $this->idDocumentMis = $idDocumentMis;

        return $this;
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
        if ($this->fields !== null) {
            return $this->fields;
        }

        $fields = get_object_vars($this);
        unset($fields['errors'], $fields['fields']);
        $this->fields = $fields;

        return $this->fields;
    }
}
