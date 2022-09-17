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
    private NativePasswordHasher $passwordHasher;

    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct($registry, OTP::class);

        $this->passwordHasher = new NativePasswordHasher(null, null, 12, \PASSWORD_BCRYPT);
    }

    public function findOneByPhone(string $phone): ?OTP
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.phone = :phone')
            ->setParameter('phone', $phone)
            ->orderBy('o.createdAt', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function verify(OTP $otp, string $code): bool
    {
        return $this->passwordHasher->verify($otp->getCode(), $code);
    }

    public function save(OTP $otp): void
    {
        $hashedCode = $this->passwordHasher->hash($otp->getCode());

        $otp->setCode($hashedCode);

        $this->_em->persist($otp);
        $this->_em->flush();
    }

    public function delete(OTP $otp): void
    {
        $this->_em->remove($otp);
        $this->_em->flush();
    }
}