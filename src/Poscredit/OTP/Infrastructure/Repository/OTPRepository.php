<?php

namespace App\Poscredit\OTP\Infrastructure\Repository;

use App\Poscredit\OTP\Domain\Entity\OTP;
use App\Poscredit\OTP\Domain\Repository\OTPRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

/**
 * Репозиторий одноразового пароля домена
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class OTPRepository extends ServiceEntityRepository implements OTPRepositoryInterface
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, OTP::class);
    }

    public function save(OTP $otp): void
    {
        $this->_em->persist($otp);
        $this->_em->flush();
    }

    public function delete(OTP $otp): void
    {
        $this->_em->remove($otp);
        $this->_em->flush();
    }
}