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
     * Ищет одноразовый пароль по идентификатору
     * 
     * @param string $id
     * 
     * @return OTP|null
     */
    public function find(string $id): ?OTP;

    /**
     * Сверяет одноразовый пароль с хешем
     * 
     * @param OTP $otp
     * @param string $code
     * 
     * @return bool
     */
    public function verify(OTP $otp, string $code): bool;

    /**
     * Ищет последний отправленный одноразовый пароль по номеру телефона
     * 
     * @param string $phone
     * 
     * @return OTP|null
     */
    public function findOneByPhone(string $phone): ?OTP;

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