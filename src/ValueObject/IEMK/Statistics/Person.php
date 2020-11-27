<?php

namespace DocDoc\RgsApiClient\ValueObject\IEMK\Statistics;

use DocDoc\RgsApiClient\ValueObject\AbstractValidateValueObject;
use JsonSerializable;

/**
 * Объект Персона ЕГИСЗ ИЭМК
 * Валидируется, имеет Json представление согласно спецификации, имеет методы управления состоянием
 * Применяется для создания случая обслуживания в сервисе ЕГИСЗ ИЭМК
 *
 */
class Person extends AbstractValidateValueObject implements JsonSerializable
{
    /**
     * @var HumanName
     */
    private $HumanName;

    /**
     * @var int
     */
    private $IdPersonMis;

    /**
     * @return HumanName
     */
    public function getHumanName(): HumanName
    {
        return $this->HumanName;
    }

    /**
     * @param HumanName $HumanName
     */
    public function setHumanName(HumanName $HumanName): void
    {
        $this->HumanName = $HumanName;
    }

    /**
     * @return int
     */
    public function getIdPersonMis(): int
    {
        return $this->IdPersonMis;
    }

    /**
     * @param int $IdPersonMis
     */
    public function setIdPersonMis(int $IdPersonMis): void
    {
        $this->IdPersonMis = $IdPersonMis;
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
            $this->fields = ['HumanName', 'IdPersonMis'];
        }

        return $this->fields;
    }
}
