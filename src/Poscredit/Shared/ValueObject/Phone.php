<?php

namespace App\Poscredit\Shared\ValueObject;

use App\Poscredit\Shared\ValueObject\AbstractValueObject;

/**
 * Телефон
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class Phone extends AbstractValueObject
{
    protected string $phone;

    public function __construct(string $phone)
    {
        $this->validate($phone);

        $this->phone = $phone;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(): string
    {
        return $this->phone;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($phone): void
    {
        if (!preg_match('/^(?:7|8)\d{10}$/', $phone)) {
            throw new \InvalidArgumentException("Not valid phone");
        }
    }
}