<?php

namespace App\Poscredit\OTP\Application\Model;

/**
 * Описывает модель команды создания одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class CreateOTPModel
{
    private string $phone;

    public function __construct(string $phone)
    {
        $this->phone = $phone;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}