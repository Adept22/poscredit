<?php

namespace App\Poscredit\OTP\Application\Model;

/**
 * Описывает модель команды проверки одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class VerifyOTPCommand
{
    private string $id;

    private string $code;

    public function __construct(
        string $id,
        string $code
    ) {
        $this->id = $id;
        $this->code = $code;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}