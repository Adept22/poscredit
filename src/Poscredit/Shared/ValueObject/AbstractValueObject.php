<?php

namespace App\Poscredit\Shared\ValueObject;

abstract class AbstractValueObject
{
    abstract public function getValue();

    abstract public function validate($value);
}