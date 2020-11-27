<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use JsonSerializable;

class MedRecord  extends AbstractValidateValueObject implements JsonSerializable
{
    /**
     * Список ошибок валидации
     *
     * @return array <int, DocumentAttachment>
     */
    private $Attachments;

    /**
     * @var MedicalStaff
     */
    private $Author;

    /**
     * @var string
     */
    private $CreationDate;

    /**
     * @var string
     */
    private $Header;

    /**
     * @var string
     */
    private $IdDocumentMis;

    /**
     * @return mixed
     */
    public function getAttachments()
    {
        return $this->Attachments;
    }

    /**
     * @param mixed $Attachments
     */
    public function setAttachments($Attachments): void
    {
        $this->Attachments = $Attachments;
    }

    /**
     * @return MedicalStaff
     */
    public function getAuthor(): MedicalStaff
    {
        return $this->Author;
    }

    /**
     * @param MedicalStaff $Author
     */
    public function setAuthor(MedicalStaff $Author): void
    {
        $this->Author = $Author;
    }

    /**
     * @return string
     */
    public function getCreationDate(): string
    {
        return $this->CreationDate;
    }

    /**
     * @param string $CreationDate
     */
    public function setCreationDate(string $CreationDate): void
    {
        $this->CreationDate = $CreationDate;
    }

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->Header;
    }

    /**
     * @param string $Header
     */
    public function setHeader(string $Header): void
    {
        $this->Header = $Header;
    }

    /**
     * @return string
     */
    public function getIdDocumentMis(): string
    {
        return $this->IdDocumentMis;
    }

    /**
     * @param string $IdDocumentMis
     */
    public function setIdDocumentMis(string $IdDocumentMis): void
    {
        $this->IdDocumentMis = $IdDocumentMis;
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
