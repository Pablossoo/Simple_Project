<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Messenger\CreateCart;
use App\Service\Cart\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", methods={"POST"}, name="cart-create")
 */
final class CreateController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(): Response
    {
        /** @var Cart $cart */
        $cart = $this->handle(new CreateCart());

        return new JsonResponse([
            'cart_id' => $cart->getId(),
        ], Response::HTTP_CREATED);
    }
}
