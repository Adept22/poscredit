<?php

namespace App\Poscredit\OTP\Application\EventSubscriber;

use App\Poscredit\OTP\Application\Event\OnOTPCreatedEvent;
use App\Poscredit\SMSRU\Application\Model\SendSMSModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Слушатель событий создания одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 */
final class OnOTPCreatedEventSubscriber implements EventSubscriberInterface
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            OnOTPCreatedEvent::class => 'sendSMS',
        ];
    }

    public function sendSMS(OnOTPCreatedEvent $event): void
    {
        $sendSMSModel = new SendSMSModel(
            [$event->getPhone()],
            $event->getCode()
        );
        
        $this->messageBus->dispatch($sendSMSModel);
    }
}