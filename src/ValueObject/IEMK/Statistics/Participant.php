<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\Enum\IEMK\RoleEnum;
use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use DocDoc\RgsApiClient\ValueObject\IEMK\IemkValueObjectTrait;
use JsonSerializable;

/**
 * Объект Ответственный медицинский работник ЕГИСЗ ИЭМК
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания случая обслуживания в сервисе ЕГИСЗ ИЭМК
 */
class Participant extends AbstractValidateValueObject implements JsonSerializable
{
    use IemkValueObjectTrait;

    /**
     * Роль работника в оказании помощи (Справочник OID: 1.2.643.5.1.13.2.7.1.30)
     * @var int
     */
    private $idRole;

    /**
     * Данные медицинского работника
     * @var MedicalStaff
     */
    private $doctor;

    /**
     * @return int
     */
    public function getIdRole(): int
    {
        return $this->idRole;
    }

    /**
     * @param int $idRole
     *
     * @return Participant
     */
    public function setIdRole(int $idRole): Participant
    {
        $this->idRole = $idRole;

        return $this;
    }

    /**
     * @return MedicalStaff
     */
    public function getDoctor(): MedicalStaff
    {
        return $this->doctor;
    }

    /**
     * @param MedicalStaff $doctor
     *
     * @return Participant
     */
    public function setDoctor(MedicalStaff $doctor): Participant
    {
        $this->doctor = $doctor;

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
     * Проверка валидности значений объекта.
     */
    public function validate(): bool
    {
        parent::validate();
        if (RoleEnum::getValue($this->idRole) === null) {
            $this->errors['idRole'] = 'Недопустимое значение роли медицинского работника';
        }

        return !(bool)$this->errors;
    }

    /**
     * @inheritDoc
     */
    protected function getFields(): array
    {
        if ($this->fields === null) {
            $this->fields = ['idRole', 'doctor'];
        }

        return $this->fields;
    }

    /**
     * Список ошибок валидации
     *
     * @return array <string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
