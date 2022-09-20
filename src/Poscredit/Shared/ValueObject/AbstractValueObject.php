<?php

namespace App\Poscredit\Shared\ValueObject;

abstract class AbstractValueObject
{
    /**
     * Возвращает значение свойства
     */
    abstract public function getValue();

    /**
     * Валидирует значение
     */
    abstract public function validate($value);

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getValue();
    }
}