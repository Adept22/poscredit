<?php

namespace App\Poscredit\SMSRU\Domain\Event;

use App\DomainEventInterface;
use App\Poscredit\Shared\ValueObject\ID;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Событие созданного одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class SMSCreatedEvent extends Event implements DomainEventInterface
{
    private ID $smsId;

    protected \DateTimeImmutable $occur;

    public function __construct(ID $smsId)
    {
        $this->smsId = $smsId;
        $this->occur = new \DateTimeImmutable();
    }

    public function getID(): ID
    {
        return $this->smsId;
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }
}