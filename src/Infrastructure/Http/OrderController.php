<?php

namespace App\Infrastructure\Http;

use App\Application\order\AddOrderUseCase;
use App\Application\order\GetOrderUseCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/api/orders', name: 'app_orders', methods: ['get'])]
    public function orders(GetOrderUseCase $orderUseCase, EntityManagerInterface $entityManager): Response
    {
        $orders = $orderUseCase->execute($entityManager);
        return new JsonResponse($orders, 200);
    }

    #[Route('/api/orders', name: 'app_add_order', methods: ['post'])]
    public function saveOrder(AddOrderUseCase $addOrderUseCase, EntityManagerInterface $entityManager, Request $request): Response
    {
        $response = 500;
        $data = json_decode($request->getContent());
        if ($addOrderUseCase->execute($entityManager, $data)) {
            $response = 201;
        }
        return new Response('', $response);
    }
}
