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
     * Сохраняет сущность пароль
     * 
     * @param SMS $sms
     * 
     * @return void
     */
    public function save(SMS $comment): void;

    /**
     * Удаляет сущность
     * 
     * @param SMS $sms
     * 
     * @return void
     */
    public function delete(SMS $comment): void;
}