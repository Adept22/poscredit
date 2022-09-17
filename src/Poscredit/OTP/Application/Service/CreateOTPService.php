<?php

namespace App\Poscredit\OTP\Application\Service;

use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Poscredit\OTP\Application\Model\CreateOTPCommand;
use App\Poscredit\OTP\Domain\Entity\OTP;
use App\Poscredit\OTP\Domain\Repository\OTPRepositoryInterface;
use App\Poscredit\OTP\Domain\Entity\ValueObject\OTPId;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Слушатель команд на создание одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class CreateOTPService implements MessageHandlerInterface
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

    public function __invoke(CreateOTPCommand $createOTPCommand): string
    {
        $otp = $this->otpRepository->findOneByPhone($createOTPCommand->getPhone());
        if ($otp && $otp->getExpiresAt() > new \DateTimeImmutable()) {
            throw new \InvalidArgumentException('OTP was already send');
        }

        $otp = OTP::create(
            new OTPId(Uuid::uuid1()),
            $createOTPCommand->getPhone()
        );
        
        // Правильно было бы вынести это в отдельный домен и сервис
        $body = file_get_contents(
            "https://sms.ru/sms/send?api_id=" 
            . $this->container->getParameter('smsru_api_id') 
            . "&to=" 
            . $otp->getPhone() 
            . "&msg=" 
            . urlencode($otp->getCode()) 
            . "&json=1"
        );
        $json = json_decode($body);
        
        if ($json) {
            if ($json->status != "OK") {
                throw new \RuntimeException("Unable to send code (" . $json->status_code . ")");
            }
        } else {
            throw new \RuntimeException("Unable to send code");
        }

        $this->otpRepository->save($otp);

        foreach ($otp->getDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }

        return $this->serializer->serialize($otp, 'json');
    }
}