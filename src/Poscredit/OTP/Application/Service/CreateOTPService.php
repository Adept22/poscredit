<?php

namespace App\Poscredit\OTP\Application\Service;

use App\Poscredit\OTP\Application\Event\OnOTPCreatedEvent;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Poscredit\OTP\Application\Model\CreateOTPModel;
use App\Poscredit\OTP\Domain\Entity\OTP;
use App\Poscredit\OTP\Domain\Repository\OTPRepositoryInterface;
use App\Poscredit\OTP\Infrastructure\Repository\OTPRepository;
use App\Poscredit\Shared\ValueObject\ID;
use App\Poscredit\Shared\ValueObject\Phone;

/**
 * Слушатель команд на создание одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class CreateOTPService implements MessageHandlerInterface
{
    private EventDispatcherInterface $eventDispatcher;

    private SerializerInterface $serializer;

    /** 
     * @var OTPRepository $otpRepository 
     */
    private OTPRepositoryInterface $otpRepository;

    public function __construct(
        OTPRepositoryInterface $otpRepository,
        EventDispatcherInterface $eventDispatcher,
        SerializerInterface $serializer
    ) {
        $this->otpRepository = $otpRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->serializer = $serializer;
    }

    public function __invoke(CreateOTPModel $createOTPModel): string
    {
        $otp = $this->otpRepository->findOneBy(
            ["phone.phone" => $createOTPModel->getPhone()], 
            ["createdAt" => "DESC"]
        );
        if ($otp && $otp->getExpiresAt() > new \DateTimeImmutable()) {
            throw new \InvalidArgumentException('OTP was already send');
        }

        $otp = OTP::create(
            new ID(Uuid::uuid1()),
            new Phone($createOTPModel->getPhone())
        );

        $this->otpRepository->save($otp);

        foreach ($otp->getDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }

        $this->eventDispatcher->dispatch(new OnOTPCreatedEvent(
            (string) $otp->getPhone(),
            $otp->getCode()->getValue()
        ));

        return $this->serializer->serialize($otp, 'json');
    }
}