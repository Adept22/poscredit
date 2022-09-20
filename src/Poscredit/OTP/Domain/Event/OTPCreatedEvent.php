<?php

namespace App\Poscredit\OTP\Domain\Event;

use App\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Событие создания одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class OTPCreatedEvent extends Event implements DomainEventInterface
{
    private string $otpId;

    protected \DateTimeImmutable $occur;

    public function __construct(string $otpId)
    {
        $this->otpId = $otpId;
        $this->occur = new \DateTimeImmutable();
    }

    public function getID(): string
    {
        return $this->otpId;
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }
}