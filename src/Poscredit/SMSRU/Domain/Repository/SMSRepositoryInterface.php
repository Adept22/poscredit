<?php

namespace App\Poscredit\SMSRU\Domain\Repository;

use App\Poscredit\SMSRU\Domain\Entity\SMS;

/**
 * Интерфейс репозитория одноразового пароля домена
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
interface SMSRepositoryInterface
{
    /**
     * Сохраняет одноразовый пароль
     * 
     * @param SMS $sms
     * 
     * @return void
     */
    public function save(SMS $comment): void;
}