<?php

namespace App\Poscredit\OTP\Domain\Event;

use App\DomainEventInterface;
use App\Poscredit\OTP\Domain\Entity\ValueObject\OTPId;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Событие созданного одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class OTPCreatedEvent extends Event implements DomainEventInterface
{
    private OTPId $otpId;

    protected \DateTimeImmutable $occur;

    public function __construct(OTPId $otpId)
    {
        $this->otpId = $otpId;
        $this->occur = new \DateTimeImmutable();
    }

    public function getOTPId(): OTPId
    {
        return $this->otpId;
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }
}