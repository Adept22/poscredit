<?php

namespace App\Poscredit\Shared\ValueObject;

use App\Poscredit\Shared\ValueObject\AbstractValueObject;
use Ramsey\Uuid\UuidInterface;

/**
 * Идентификатор одноразового пароля домена
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class ID extends AbstractValueObject
{
    protected UuidInterface $id;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(): UuidInterface
    {
        return $this->id;
    }

    public function validate($value): void
    { }
}