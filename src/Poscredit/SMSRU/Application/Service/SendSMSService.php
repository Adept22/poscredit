<?php

namespace App\Poscredit\SMSRU\Application\Service;

use App\Poscredit\Shared\ValueObject\ID;
use App\Poscredit\Shared\ValueObject\Phone;
use App\Poscredit\SMSRU\Domain\Entity\SMS;
use App\Poscredit\SMSRU\Domain\Repository\SMSRepositoryInterface;
use App\Poscredit\SMSRU\Application\Model\SendSMSModel;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class SendSMSService
{
    private SMSRepositoryInterface $smsRepository;
    private EventDispatcherInterface $eventDispatcher;
    private SerializerInterface $serializer;

    public function __construct(
        SMSRepositoryInterface $smsRepository,
        EventDispatcherInterface $eventDispatcher,
        SerializerInterface $serializer
    ) {
        $this->smsRepository = $smsRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->serializer = $serializer;
    }

    public function handle(SendSMSModel $sendSMSModel): string
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
        // а тут на каком-то упадет, то следующие просто не запишутся.
        foreach ($receivers as $to) {
            $sms = SMS::create(
                new ID(Uuid::uuid1()),
                new Phone($to),
                $sendSMSModel->getMsg(),
                $json->$to->sms_id,
                $json->$to->status_code
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