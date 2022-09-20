<?php

namespace App\Poscredit\Shared\ValueObject;

use App\Poscredit\Shared\ValueObject\AbstractValueObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Идентификатор одноразового пароля домена
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class Phone extends AbstractValueObject
{
    protected string $phone;

    public function __construct(string $value)
    {
        $this->validate($value);

        $this->phone = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }

    public function validate($value): void
    {
        if (!preg_match('/^(?:7|8)\d{10}$/', $value)) {
            throw new \InvalidArgumentException("Not valid phone");
        }
    }
}