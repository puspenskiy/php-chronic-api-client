<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\Enum\IEMK\RoleEnum;
use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use JsonSerializable;

/**
 * Объект Ответственный медицинский работник ЕГИСЗ ИЭМК
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания случая обслуживания в сервисе ЕГИСЗ ИЭМК
 *
 */
class Participant extends AbstractValidateValueObject implements JsonSerializable
{
    /**
     * @var int
     */
    private $IdRole;

    /**
     * @var MedicalStaff
     */
    private $Doctor;

    /**
     * @return int
     */
    public function getIdRole(): int
    {
        return $this->IdRole;
    }

    /**
     * @param int $IdRole
     */
    public function setIdRole(int $IdRole): void
    {
        $this->IdRole = $IdRole;
    }

    /**
     * @return MedicalStaff
     */
    public function getDoctor(): MedicalStaff
    {
        return $this->Doctor;
    }

    /**
     * @param MedicalStaff $Doctor
     */
    public function setDoctor(MedicalStaff $Doctor): void
    {
        $this->Doctor = $Doctor;
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
        if (RoleEnum::getValue($this->IdRole) === null) {
            $this->errors['IdRole'] = 'Недопустимое значение роли медицинского работника';
        }

        return !(bool)$this->errors;
    }

    /**
     * @inheritDoc
     */
    protected function getFields(): array
    {
        if ($this->fields === null) {
            $this->fields = ['IdRole', 'Doctor'];
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
