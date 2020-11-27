<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Patient;

use DocDoc\RgsApiClient\Enum\IEMK\SexEnum;
use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use JsonSerializable;

/**
 * Объект пациента ЕГИСЗ ИЭМК
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания пациента в сервисе ЕГИСЗ ИЭМК
 *
 * @see https://chronicmonitor.docs.apiary.io/#reference/patients/apiv1patient/post
 */
class Patient extends AbstractValidateValueObject implements JsonSerializable
{
    /**
     * Фамилия пациента
     * @var string
     */
    private $FamilyName;

    /**
     * Имя пациента
     * @var string
     */
    private $GivenName;

    /**
     * Отчество пациента
     * @var string|null
     */
    private $MiddleName;

    /**
     * Пол
     * @var int
     */
    private $Sex;

    /**
     * Дата рождения
     * @var string
     */
    private $BirthDate;

    /**
     * Внешний идентификатор пациента (External id)
     * @var string
     */
    private $IdPatientMIS;

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
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->MiddleName;
    }

    /**
     * @param string|null $MiddleName
     */
    public function setMiddleName(?string $MiddleName): void
    {
        $this->MiddleName = $MiddleName;
    }

    /**
     * @return int
     */
    public function getSex(): int
    {
        return $this->Sex;
    }

    /**
     * @param int $Sex
     */
    public function setSex(int $Sex): void
    {
        $this->Sex = $Sex;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->BirthDate;
    }

    /**
     * @param string $BirthDate
     */
    public function setBirthDate(string $BirthDate): void
    {
        $this->BirthDate = $BirthDate;
    }

    /**
     * @return string
     */
    public function getIdPatientMIS(): string
    {
        return $this->IdPatientMIS;
    }

    /**
     * @param string $IdPatientMIS
     */
    public function setIdPatientMIS(string $IdPatientMIS): void
    {
        $this->IdPatientMIS = $IdPatientMIS;
    }

    /**
     * Проверка валидности значений объекта.
     */
    public function validate(): bool
    {
        parent::validate();
        if (
            SexEnum::getValue($this->Sex) === null
        ) {
            $this->errors['Sex'] = 'Недопустимое значение пола пациента';
        }

        return !(bool)$this->errors;
    }

    /**
     * @inheritDoc
     */
    protected function getRequiredFields(): array
    {
        $fields = $this->getFields();
        unset($fields['MiddleName']);

        return $fields;
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

        if ($this->MiddleName === null) {
            unset($fields['MiddleName']);
        }

        $this->fields = $fields;
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
