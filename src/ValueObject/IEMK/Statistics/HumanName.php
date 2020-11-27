<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use JsonSerializable;

/**
 * Объект ФИО ЕГИСЗ ИЭМК
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания случая обслуживания в сервисе ЕГИСЗ ИЭМК
 *
 */
class HumanName extends AbstractValidateValueObject implements JsonSerializable
{
    /**
     * Фамилия пациента
     *
     * @var string
     */
    private $FamilyName;

    /**
     * Имя пациента
     *
     * @var string
     */
    private $GivenName;

    /**
     * @return string
     */
    public function getFamilyName(): string
    {
        return $this->FamilyName;
    }

    /**
     * @param string $FamilyName
     */
    public function setFamilyName(string $FamilyName): void
    {
        $this->FamilyName = $FamilyName;
    }

    /**
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->GivenName;
    }

    /**
     * @param string $GivenName
     */
    public function setGivenName(string $GivenName): void
    {
        $this->GivenName = $GivenName;
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
            $this->fields = ['FamilyName', 'GivenName'];
        }

        return $this->fields;
    }
}
