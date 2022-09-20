<?php

namespace App\Poscredit\SMSRU\Domain\Entity;

use App\DomainEvents;
use App\Poscredit\Shared\ValueObject\ID;
use App\Poscredit\Shared\ValueObject\Phone;
use App\Poscredit\SMSRU\Domain\Event\SMSCreatedEvent;
use Ramsey\Uuid\Uuid;

/**
 * СМС
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
class SMS extends DomainEvents
{
    private string $id;

    private Phone $to;
    
    private string $msg;

    private int $status;
    
    private ?string $smsruId;

    private \DateTimeImmutable $createdAt;

    public function __construct(
        ID $id,
        Phone $to,
        string $msg,
        int $status,
        ?string $smsruId = null,
        ?\DateTimeImmutable $createdAt = null
    ) {
        $this->id = $id->getValue();
        $this->to = $to;
        $this->msg = $msg;
        $this->smsruId = $smsruId;
        $this->status = $status;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
    }

    public function getId(): ID
    {
        return new ID(Uuid::fromString($this->id));
    }

    public function getTo(): Phone
    {
        return $this->to;
    }

    public function getMsg(): string
    {
        return $this->msg;
    }

    public function getSmsruId(): ?string
    {
        return $this->smsruId;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public static function create(
        ID $id,
        Phone $to,
        string $msg,
        int $status,
        ?string $smsruId = null
    ): self
    {
        $sms = new SMS($id, $to, $msg, $status, $smsruId);

        $sms->addDomainEvent(new SMSCreatedEvent($id));

        return $sms;
    }
}