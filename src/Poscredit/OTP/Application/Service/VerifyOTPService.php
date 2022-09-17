<?php

namespace App\Poscredit\OTP\Application\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Poscredit\OTP\Application\Model\VerifyOTPCommand;
use App\Poscredit\OTP\Domain\Entity\OTP;
use App\Poscredit\OTP\Domain\Repository\OTPRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Слушатель команд на проверку одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class VerifyOTPService implements MessageHandlerInterface
{
    private EventDispatcherInterface $eventDispatcher;

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

    public function __invoke(VerifyOTPCommand $verifyOTPCommand): string
    {
        /** @var OTP */
        $otp = $this->otpRepository->find($verifyOTPCommand->getId());
        if (!$otp || $otp->getExpiresAt() < new \DateTimeImmutable()) {
            throw new \InvalidArgumentException('OTP is expired, please send a new one');
        }

        $eq = $this->otpRepository->verify($otp, $verifyOTPCommand->getCode());

        if ($eq) {
            $this->otpRepository->delete($otp);
        }

        foreach ($otp->getDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }

        return $this->serializer->serialize($eq, 'json');
    }
}