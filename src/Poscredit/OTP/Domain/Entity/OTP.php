<?php

namespace App\Poscredit\OTP\Domain\Entity;

use App\DomainEvents;
use App\Poscredit\OTP\Domain\Event\OTPCreatedEvent;
use App\Poscredit\OTP\Domain\Entity\ValueObject\OTPId;

/**
 * Одноразового пароль домена
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
class OTP extends DomainEvents
{
    private string $id;

    private string $phone;

    private string $code;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $expiresAt;

    public function __construct(
        OTPId $id, 
        string $phone, 
        string $code, 
        \DateTimeImmutable $createdAt, 
        \DateTimeImmutable $expiresAt
    ) {
        $this->id = $id->getValue();
        $this->phone = $phone;
        $this->code = $code;
        $this->createdAt = $createdAt;
        $this->expiresAt = $expiresAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getExpiresAt(): \DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public static function create(
        OTPId $id, 
        string $phone
    ): self
    {
        $now = new \DateTimeImmutable();

        $otp = new OTP(
            $id,
            $phone,
            sprintf("%06d", mt_rand(1, 999999)),
            $now,
            $now->modify('+5 minutes')
        );

        $otp->addDomainEvent(new OTPCreatedEvent($id));

        return $otp;
    }
}