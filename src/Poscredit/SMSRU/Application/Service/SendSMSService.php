<?php

namespace App\Poscredit\SMSRU\Application\Service;

use App\Poscredit\Shared\ValueObject\ID;
use App\Poscredit\Shared\ValueObject\Phone;
use App\Poscredit\SMSRU\Domain\Entity\SMS;
use App\Poscredit\SMSRU\Domain\Repository\SMSRepositoryInterface;
use App\Poscredit\SMSRU\Application\Model\SendSMSModel;
use App\Poscredit\SMSRU\Infrastructure\Repository\SMSRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Слушает событие отправки смс
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class SendSMSService implements MessageHandlerInterface
{
    private ContainerInterface $container;

    private EventDispatcherInterface $eventDispatcher;

    private SerializerInterface $serializer;
    
    /** 
     * @var SMSRepository $smsRepository 
     */
    private SMSRepositoryInterface $smsRepository;

    public function __construct(
        SMSRepositoryInterface $smsRepository,
        ContainerInterface $container,
        EventDispatcherInterface $eventDispatcher,
        SerializerInterface $serializer
    ) {
        $this->smsRepository = $smsRepository;
        $this->container = $container;
        $this->eventDispatcher = $eventDispatcher;
        $this->serializer = $serializer;
    }

    public function __invoke(SendSMSModel $sendSMSModel): string
    {
        // TODO: Как временное решение для нескольких получателей, если абстрагироваться от ОТП.
        $receivers = $sendSMSModel->getTo();

        // TODO: Переделать на cURL/Guzzle на POST запросе на случай большого кол-ва получателей и/или текста смс.
        $body = file_get_contents(
            "https://sms.ru/sms/send?api_id=" 
            . $this->container->getParameter('smsru_api_id') 
            . "&to=" 
            . implode(",", $receivers)
            . "&msg=" 
            . urlencode($sendSMSModel->getMsg()) 
            . "&json=1"
        );
        $json = json_decode($body);

        $created = [];

        // Не совсем корректно, если вдруг все смс через API ушли, 
        // а тут на каком-то упадет, то не обработанные просто не запишутся.
        foreach ($json->sms as $to => $sms) {
            $sms = SMS::create(
                new ID(Uuid::uuid1()),
                new Phone($to),
                $sendSMSModel->getMsg(),
                $sms->status_code,
                $sms->sms_id ?? null
            );

            $this->smsRepository->save($sms);

            foreach ($sms->getDomainEvents() as $domainEvent) {
                $this->eventDispatcher->dispatch($domainEvent);
            }

            $created[] = $sms;
        }

        return $this->serializer->serialize($created, 'json');
    }
}