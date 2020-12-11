<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use DocDoc\RgsApiClient\ValueObject\IEMK\IemkValueObjectTrait;
use JsonSerializable;

/**
 * Объект Медицинский работник ЕГИСЗ ИЭМК
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания случая обслуживания в сервисе ЕГИСЗ ИЭМК
 *
 */
class MedicalStaff extends AbstractValidateValueObject implements JsonSerializable
{
    use IemkValueObjectTrait;

    /**
     * Идентификатор специальности медицинского работника.
     * (Справочник OID:1.2.643.5.1.13.2.1.1.181)
     * @var int
     */
    private $idSpeciality;

    /**
     * Идентификатор должности медицинского работника.
     * (Справочник OID:1.2.643.5.1.13.2.1.1.607)
     * @var int
     */
    private $idPosition;

    /**
     * @var Person
     */
    private $person;

    /**
     * @return int
     */
    public function getIdSpeciality(): int
    {
        return $this->idSpeciality;
    }

    /**
     * @param int $idSpeciality
     *
     * @return MedicalStaff
     */
    public function setIdSpeciality(int $idSpeciality): MedicalStaff
    {
        $this->idSpeciality = $idSpeciality;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdPosition(): int
    {
        return $this->idPosition;
    }

    /**
     * @param int $idPosition
     *
     * @return MedicalStaff
     */
    public function setIdPosition(int $idPosition): MedicalStaff
    {
        $this->idPosition = $idPosition;

        return $this;
    }

    /**
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }

    /**
     * @param Person $person
     *
     * @return MedicalStaff
     */
    public function setPerson(Person $person): MedicalStaff
    {
        $this->person = $person;

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
            $this->fields = ['idSpeciality', 'idPosition', 'person'];
        }

        return $this->fields;
    }
}
