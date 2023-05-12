<?php

namespace App\UI\Http\Controller;

use App\Application\UseCase\Order\AddBuyOrderUserCase;
use App\Application\UseCase\Order\AddOrderUseCase;
use App\Application\UseCase\Order\AddSellOrderUserCase;
use App\Application\UseCase\Order\GetOrderUseCase;
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

    #[Route('/orders/create-sales-order', name: 'app_create_sales_order', methods: ['post'])]
    public function saveSalesOrder(AddSellOrderUserCase $addSellOrderUserCase, EntityManagerInterface $entityManager, Request $request): Response
    {
        $data = $request->request->all();
        $addSellOrderUserCase->execute($entityManager, $data);
        return $this->redirect($this->generateUrl('app_portfolio_search', array('id' => $data['portfolio'], 'order-type' => 'sell')));
    }

    #[Route('/orders/create-buy-order', name: 'app_create_buy_order', methods: ['post'])]
    public function saveBuyOrder(AddBuyOrderUserCase $addBuyOrderUserCase, EntityManagerInterface $entityManager, Request $request): Response
    {
        $data = $request->request->all();
        $addBuyOrderUserCase->execute($entityManager, $data);
        return $this->redirect($this->generateUrl('app_portfolio_search', array('id' => $data['portfolio'], 'order-type' => 'buy')));
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
