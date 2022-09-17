<?php

namespace App;

use App\DomainEventInterface;

/**
 * Абстрактный класс событий домена
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
abstract class DomainEvents
{
    protected array $domainEvents = [];

    public function addDomainEvent(DomainEventInterface $event): self
    {
        $this->domainEvents[] = $event;

        return $this;
    }

    public function getDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;

        $this->domainEvents = [];

        return $domainEvents;
    }
}