<?php

namespace App\Poscredit\OTP\Domain\Entity;

use App\Poscredit\Shared\ValueObject\AbstractValueObject;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

/**
 * Идентификатор одноразового пароля домена
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class Code extends AbstractValueObject
{
    private NativePasswordHasher $passwordHasher;

    protected string $code;

    protected string $hash;

    public function __construct()
    {
        $code = sprintf("%06d", mt_rand(1, 999999));
        
        $this->passwordHasher = new NativePasswordHasher(null, null, 12, \PASSWORD_BCRYPT);

        $this->code = $code;
        $this->hash($code);
    }

    /**
     * @param string $plain
     * 
     * @return void
     */
    protected function hash(string $plain): void
    {
        $this->hash = $this->passwordHasher->hash($plain);
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(): int
    {
        return $this->code;
    }

    /**
     * @param string $plain
     * 
     * @return bool
     */
    public function compare(string $plain): bool
    {
        return $this->passwordHasher->verify($this->hash, $plain);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->hash;
    }

    public function validate($value): void
    { }
}