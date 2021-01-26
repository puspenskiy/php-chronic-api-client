<?php


namespace DocDoc\RgsApiClient\ValueObject\IEMK;

trait IemkValueObjectTrait
{
    public function toArray()
    {
        $map = [];

        foreach (get_object_vars($this) as $propName => $propVal) {
            if (is_array($propVal)) {
                $arrayValue = [];
                foreach ($propVal as $item) {
                    $arrayValue[] = $this->processValue($item);
                }
                $map[ucfirst($propName)] = $arrayValue;
            } else {
                $map[ucfirst($propName)] = $this->processValue($propVal);
            }
        }

        return $map;
    }

    protected function processValue($value)
    {
        return is_object($value) && method_exists($value, 'toArray') ? $value->toArray() : $value;
    }
}