<?php

namespace App\Poscredit\SMSRU\Domain\Entity;

use App\DomainEvents;
use App\Poscredit\Shared\ValueObject\ID;
use App\Poscredit\Shared\ValueObject\Phone;
use App\Poscredit\SMSRU\Domain\Event\SMSCreatedEvent;

/**
 * Одноразового пароль домена
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
class SMS extends DomainEvents
{
    private ID $id;

    private Phone $to;
    
    private string $msg;

    private string $smsruId;

    private int $status;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $updatedAt;

    public function __construct(
        ID $id,
        Phone $to,
        string $msg,
        string $smsruId,
        int $status,
        ?\DateTimeImmutable $createdAt = null,
        ?\DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id->getValue();
        $this->to = $to;
        $this->msg = $msg;
        $this->smsruId = $smsruId;
        $this->status = $status;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new \DateTimeImmutable();
    }

    public function getId(): ID
    {
        return $this->id;
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

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public static function create(
        ID $id,
        Phone $to,
        string $msg,
        string $smsruId,
        int $status
    ): self
    {
        $sms = new SMS(
            $id, 
            $to, 
            $msg, 
            $smsruId, 
            $status
        );

        $sms->addDomainEvent(new SMSCreatedEvent($id));

        return $sms;
    }
}