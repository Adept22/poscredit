<?php

namespace App\Poscredit\OTP\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Poscredit\OTP\Application\Model\CreateOTPCommand;

/**
 * Контролер реализует ендпоинт генерации одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 * 
 * @Route("/api/otp/", name="api_otp_post", methods={"POST"})
 */
final class PostOTPController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $args = json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        $createOTPCommand = new CreateOTPCommand($args['phone']);

        $result = $this->handle($createOTPCommand);

        return JsonResponse::fromJsonString($result);
    }
}