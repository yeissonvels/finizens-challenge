<?php

namespace App\Application\order;

use App\Domain\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

class GetOrderUseCase
{
    public function execute(EntityManagerInterface $entityManager): array
    {
        $orderRepository = $entityManager->getRepository(Order::class);
        return $orderRepository->findAll();
    }
}
