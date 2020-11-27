<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use JsonSerializable;

/**
 * Объект Медицинский работник ЕГИСЗ ИЭМК
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания случая обслуживания в сервисе ЕГИСЗ ИЭМК
 *
 */
class MedicalStaff extends AbstractValidateValueObject implements JsonSerializable
{
    /**
     * Идентификатор специальности медицинского работника.
     * (Справочник OID:1.2.643.5.1.13.2.1.1.181)
     * @var int
     */
    private $IdSpeciality;

    /**
     * Идентификатор должности медицинского работника.
     * (Справочник OID:1.2.643.5.1.13.2.1.1.607)
     * @var int
     */
    private $IdPosition;

    /**
     * @var Person
     */
    private $Person;

    /**
     * @return int
     */
    public function getIdSpeciality(): int
    {
        return $this->IdSpeciality;
    }

    /**
     * @param int $IdSpeciality
     */
    public function setIdSpeciality(int $IdSpeciality): void
    {
        $this->IdSpeciality = $IdSpeciality;
    }

    /**
     * @return int
     */
    public function getIdPosition(): int
    {
        return $this->IdPosition;
    }

    /**
     * @param int $IdPosition
     */
    public function setIdPosition(int $IdPosition): void
    {
        $this->IdPosition = $IdPosition;
    }

    /**
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->Person;
    }

    /**
     * @param Person $Person
     */
    public function setPerson(Person $Person): void
    {
        $this->Person = $Person;
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
            $this->fields = ['IdSpeciality', 'IdPosition', 'Person'];
        }

        return $this->fields;
    }
}
