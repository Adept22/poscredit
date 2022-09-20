<?php

namespace App\Poscredit\OTP\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Poscredit\OTP\Application\Model\VerifyOTPModel;

/**
 * Контролер реализует ендпоинт проверки одноразового пароля
 * 
 * @author Владислав Теренчук <asdof71@yandex.ru>
 * 
 * @Route("/api/otp/{id}", name="api_otp_put", methods={"PUT"})
 */
final class PutOTPController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $args = json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        $verifyOTPModel = new VerifyOTPModel($id, $args['code']);

        $result = $this->handle($verifyOTPModel);

        return JsonResponse::fromJsonString($result);
    }
}