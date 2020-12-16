<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use DocDoc\RgsApiClient\ValueObject\IEMK\IemkValueObjectTrait;
use JsonSerializable;

/**
 * Объект ФИО ЕГИСЗ ИЭМК
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания случая обслуживания в сервисе ЕГИСЗ ИЭМК
 *
 */
class HumanName extends AbstractValidateValueObject implements JsonSerializable
{
    use IemkValueObjectTrait;

    /** @var string Фамилия пациента */
    private $familyName;

    /** @var string Имя пациента */
    private $givenName;

    /**
     * @return string
     */
    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    /**
     * @param string $familyName
     *
     * @return HumanName
     */
    public function setFamilyName(string $familyName): HumanName
    {
        $this->familyName = $familyName;

        return $this;
    }

    /**
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    /**
     * @param string $givenName
     *
     * @return HumanName
     */
    public function setGivenName(string $givenName): HumanName
    {
        $this->givenName = $givenName;

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
        if ($this->fields === null) {
            $this->fields = ['familyName', 'givenName'];
        }

        return $this->fields;
    }
}
