<?php

namespace App\Poscredit\SMSRU\Application\Model;

/**
 * Описывает модель команды создания одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class SendSMSModel
{
    private array $to;

    private string $msg;

    public function __construct(array $to, string $msg)
    {
        $this->to = $to;
        $this->msg = $msg;
    }

    public function getTo(): array
    {
        return $this->to;
    }

    public function getMsg(): string
    {
        return $this->msg;
    }
}