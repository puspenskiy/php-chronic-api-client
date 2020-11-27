<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\Enum\IEMK\InitiatorTypeEnum;
use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use JsonSerializable;

/**
 * Объект Инициатор телемед-консультации ЕГИСЗ ИЭМК
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания случая обслуживания в сервисе ЕГИСЗ ИЭМК
 *
 */
class Initiator  extends AbstractValidateValueObject implements JsonSerializable
{
    /**
     * Идентификатор типа инициатора проведения телемедицинской консультации
     * Справочник OID: 1.2.643.2.69.1.1.1.129
     * @var int
     */
    private $InitiatorType;

    /**
     * @var MedicalStaff
     */
    private $Doctor;

    /**
     * @return int
     */
    public function getInitiatorType(): int
    {
        return $this->InitiatorType;
    }

    /**
     * @param int $InitiatorType
     */
    public function setInitiatorType(int $InitiatorType): void
    {
        $this->InitiatorType = $InitiatorType;
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
        parent::validate();
        if (InitiatorTypeEnum::getValue($this->InitiatorType) === null) {
            $this->errors['InitiatorType'] = 'Недопустимое значение типа инициатора проведения телемедицинской консультации';
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
            $this->fields = ['InitiatorType', 'Doctor'];
        }

        return $this->fields;
    }
}
