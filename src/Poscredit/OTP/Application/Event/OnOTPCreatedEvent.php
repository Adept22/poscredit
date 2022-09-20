<?php

namespace App\Poscredit\OTP\Application\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Событие создания одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class OnOTPCreatedEvent extends Event
{
    private string $phone;
    
    private string $code;

    public function __construct(string $phone, string $code)
    {
        $this->phone = $phone;
        $this->code = $code;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}