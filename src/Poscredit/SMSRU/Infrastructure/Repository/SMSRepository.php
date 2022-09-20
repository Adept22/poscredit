<?php

namespace App\Poscredit\SMSRU\Infrastructure\Repository;

use App\Poscredit\SMSRU\Domain\Entity\SMS;
use App\Poscredit\SMSRU\Domain\Repository\SMSRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Репозиторий sms домена
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class SMSRepository extends ServiceEntityRepository implements SMSRepositoryInterface
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, SMS::class);
    }

    /**
     * {@inheritDoc}
     */
    public function save(SMS $sms): void
    {
        $this->_em->persist($sms);
        $this->_em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function delete(SMS $sms): void
    {
        $this->_em->remove($sms);
        $this->_em->flush();
    }
}