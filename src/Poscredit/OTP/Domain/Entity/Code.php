<?php

namespace App\Poscredit\OTP\Domain\Entity;

use App\Poscredit\Shared\ValueObject\AbstractValueObject;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

/**
 * Код одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class Code extends AbstractValueObject
{
    private string $plain;

    protected string $code;

    public function __construct(?string $plain = null)
    {
        $this->plain = $plain ?? sprintf("%06d", mt_rand(1, 999999));
        
        $this->code = (new NativePasswordHasher())->hash($this->plain);
    }

    public function getPlain(): string
    {
        return $this->plain;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Проверяет совпадение кода с сохраненым хешем
     * 
     * @param string $plain
     * 
     * @return bool
     */
    public function verify(string $plain): bool
    {
        return (new NativePasswordHasher())->verify($this->code, $plain);
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(): string
    {
        return $this->code;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value): void
    { }
}