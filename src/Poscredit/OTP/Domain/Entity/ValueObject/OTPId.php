<?php

namespace App\Poscredit\OTP\Domain\Entity\ValueObject;

use Ramsey\Uuid\UuidInterface;

/**
 * Идентификатор одноразового пароля домена
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class OTPId
{
    protected UuidInterface $uuid;

    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function getValue(): UuidInterface
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }
}