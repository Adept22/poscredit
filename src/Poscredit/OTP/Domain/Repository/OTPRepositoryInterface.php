<?php

namespace App\Poscredit\OTP\Domain\Repository;

use App\Poscredit\OTP\Domain\Entity\OTP;

/**
 * Интерфейс репозитория одноразового пароля домена
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
interface OTPRepositoryInterface
{
    /**
     * Сохраняет одноразовый пароль
     * 
     * @param OTP $otp
     * 
     * @return void
     */
    public function save(OTP $comment): void;

    /**
     * Удаляет одноразовый пароль
     * 
     * @param OTP $otp
     * 
     * @return void
     */
    public function delete(OTP $comment): void;
}