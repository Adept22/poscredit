<?php

namespace App\Poscredit\OTP\Application\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Poscredit\OTP\Application\Model\VerifyOTPModel;
use App\Poscredit\OTP\Domain\Entity\OTP;
use App\Poscredit\OTP\Domain\Repository\OTPRepositoryInterface;
use App\Poscredit\OTP\Infrastructure\Repository\OTPRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Слушатель команд на проверку одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class VerifyOTPService implements MessageHandlerInterface
{
    private EventDispatcherInterface $eventDispatcher;

    /** @var OTPRepository */
    private OTPRepositoryInterface $otpRepository;

    private SerializerInterface $serializer;

    public function __construct(
        OTPRepositoryInterface $otpRepository,
        ContainerInterface $container,
        EventDispatcherInterface $eventDispatcher,
        SerializerInterface $serializer
    ) {
        $this->otpRepository = $otpRepository;
        $this->container = $container;
        $this->eventDispatcher = $eventDispatcher;
        $this->serializer = $serializer;
    }

    public function __invoke(VerifyOTPModel $verifyOTPModel): string
    {
        /** @var OTP */
        $otp = $this->otpRepository->find($verifyOTPModel->getId());
        if (!$otp || $otp->getExpiresAt() < new \DateTimeImmutable()) {
            throw new \InvalidArgumentException('OTP is expired, please send a new one');
        }

        $eq = $this->otpRepository->verify($otp, $verifyOTPModel->getCode());

        if ($eq) {
            $this->otpRepository->delete($otp);
        }

        foreach ($otp->getDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }

        return $this->serializer->serialize($eq, 'json');
    }
}