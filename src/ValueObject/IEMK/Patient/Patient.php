<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Patient;

use DocDoc\RgsApiClient\Enum\IEMK\SexEnum;
use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use DocDoc\RgsApiClient\ValueObject\IEMK\IemkValueObjectTrait;
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
    use IemkValueObjectTrait;

    /** @var string Фамилия пациента */
    private $familyName;

    /** @var string Имя пациента */
    private $givenName;

    /** @var string|null Отчество пациента */
    private $middleName;

    /** @var int Пол */
    private $sex;

    /** @var string Дата рождения */
    private $birthDate;

    /** @var string  Внешний идентификатор пациента (External id) */
    private $idPatientMIS;

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
     * @return Patient
     */
    public function setFamilyName(string $familyName): Patient
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
     * @return Patient
     */
    public function setGivenName(string $givenName): Patient
    {
        $this->givenName = $givenName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @param string|null $middleName
     *
     * @return Patient
     */
    public function setMiddleName(?string $middleName): Patient
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * @return int
     */
    public function getSex(): int
    {
        return $this->sex;
    }

    /**
     * @param int $sex
     *
     * @return Patient
     */
    public function setSex(int $sex): Patient
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     *
     * @return Patient
     */
    public function setBirthDate(string $birthDate): Patient
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdPatientMIS(): string
    {
        return $this->idPatientMIS;
    }

    /**
     * @param string $idPatientMIS
     *
     * @return Patient
     */
    public function setIdPatientMIS(string $idPatientMIS): Patient
    {
        $this->idPatientMIS = $idPatientMIS;

        return $this;
    }

    /**
     * Проверка валидности значений объекта.
     */
    public function validate(): bool
    {
        parent::validate();
        if (
            SexEnum::getValue($this->sex) === null
        ) {
            $this->errors['sex'] = 'Недопустимое значение пола пациента';
        }

        return !(bool)$this->errors;
    }

    /**
     * @inheritDoc
     */
    protected function getRequiredFields(): array
    {
        $fields = $this->getFields();
        unset($fields['middleName']);

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

        if ($this->middleName === null) {
            unset($fields['middleName']);
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
