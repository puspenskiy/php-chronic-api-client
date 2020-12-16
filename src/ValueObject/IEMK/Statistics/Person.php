<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use DocDoc\RgsApiClient\ValueObject\IEMK\IemkValueObjectTrait;
use JsonSerializable;

/**
 * Объект Персона ЕГИСЗ ИЭМК
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания случая обслуживания в сервисе ЕГИСЗ ИЭМК
 */
class Person extends AbstractValidateValueObject implements JsonSerializable
{
    use IemkValueObjectTrait;

    /**
     * Имя персоны
     * @var HumanName
     */
    private $humanName;

    /**
     * Идентификатор персоны в системе-источнике данных
     * @var int
     */
    private $idPersonMis;

    /**
     * @return HumanName
     */
    public function getHumanName(): HumanName
    {
        return $this->humanName;
    }

    /**
     * @param HumanName $humanName
     *
     * @return Person
     */
    public function setHumanName(HumanName $humanName): Person
    {
        $this->humanName = $humanName;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdPersonMis(): int
    {
        return $this->idPersonMis;
    }

    /**
     * @param int $idPersonMis
     *
     * @return Person
     */
    public function setIdPersonMis(int $idPersonMis): Person
    {
        $this->idPersonMis = $idPersonMis;

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
            $this->fields = ['humanName', 'idPersonMis'];
        }

        return $this->fields;
    }
}
