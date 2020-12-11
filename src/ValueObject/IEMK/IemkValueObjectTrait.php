<?php


namespace DocDoc\RgsApiClient\ValueObject\IEMK;

trait IemkValueObjectTrait
{
    public function toArray()
    {
        $map = [];

        foreach (get_object_vars($this) as $propName => $propVal) {
            $map[ucfirst($propName)] = is_object($propVal) && method_exists($propVal, 'toArray') ? $propVal->toArray() : $propVal;
        }

        return $map;
    }
}