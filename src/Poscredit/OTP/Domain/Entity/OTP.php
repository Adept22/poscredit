<?php

namespace App\Poscredit\OTP\Domain\Entity;

use App\DomainEvents;
use App\Poscredit\OTP\Domain\Entity\Code;
use App\Poscredit\OTP\Domain\Event\OTPCreatedEvent;
use App\Poscredit\Shared\ValueObject\ID;
use App\Poscredit\Shared\ValueObject\Phone;

/**
 * Одноразового пароль домена
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
class OTP extends DomainEvents
{
    private ID $id;

    private Phone $phone;

    private Code $code;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $expiresAt;

    public function __construct(
        ID $id, 
        Phone $phone, 
        Code $code, 
        \DateTimeImmutable $createdAt, 
        \DateTimeImmutable $expiresAt
    ) {
        $this->id = $id->getValue();
        $this->phone = $phone;
        $this->code = $code;
        $this->createdAt = $createdAt;
        $this->expiresAt = $expiresAt;
    }

    public function getId(): ID
    {
        return $this->id;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getCode(): Code
    {
        return $this->code;
    }

    public function setCode(Code $code): self
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
        ID $id, 
        Phone $phone
    ): self
    {
        $now = new \DateTimeImmutable();

        $otp = new OTP(
            $id,
            $phone,
            new Code(),
            $now,
            $now->modify('+5 minutes')
        );

        $otp->addDomainEvent(new OTPCreatedEvent($id));

        return $otp;
    }
}