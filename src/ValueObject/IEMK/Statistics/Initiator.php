<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\Enum\IEMK\InitiatorTypeEnum;
use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use DocDoc\RgsApiClient\ValueObject\IEMK\IemkValueObjectTrait;
use JsonSerializable;

/**
 * Объект Инициатор телемед-консультации ЕГИСЗ ИЭМК
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания случая обслуживания в сервисе ЕГИСЗ ИЭМК
 */
class Initiator extends AbstractValidateValueObject implements JsonSerializable
{
    use IemkValueObjectTrait;

    /**
     * Идентификатор типа инициатора проведения телемедицинской консультации
     * Справочник OID: 1.2.643.2.69.1.1.1.129
     * @var int
     * @see InitiatorTypeEnum
     */
    private $initiatorType;

    /**
     * Врач - инициатор консультации
     * Обязателен, если тип инициатора соответствует значению "Лечащий врач"
     * @var MedicalStaff
     */
    private $doctor;

    /**
     * @return int
     */
    public function getInitiatorType(): int
    {
        return $this->initiatorType;
    }

    /**
     * @param int $initiatorType
     *
     * @return Initiator
     */
    public function setInitiatorType(int $initiatorType): Initiator
    {
        $this->initiatorType = $initiatorType;

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
     * @return Initiator
     */
    public function setDoctor(MedicalStaff $doctor): Initiator
    {
        $this->doctor = $doctor;

        return $this;
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

    /**
     * Проверка валидности значений объекта.
     */
    public function validate(): bool
    {
        if (InitiatorTypeEnum::getValue($this->initiatorType) === null) {
            $this->errors['initiatorType'] = 'Недопустимое значение типа инициатора проведения телемедицинской консультации';
        }
        if ($this->initiatorType === InitiatorTypeEnum::ATTENDING_DOCTOR && $this->doctor === null) {
            $this->errors['doctor'] = "Для 'initiatorType' = {$this->initiatorType} поле 'doctor' не может быть пустым";
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
            $this->fields = ['initiatorType', 'doctor'];
        }

        return $this->fields;
    }
}
