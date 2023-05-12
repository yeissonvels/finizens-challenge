<?php

namespace App\Application\UseCase\Order;

use App\Domain\Model\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

class GetOrderUseCase
{
    public function execute(EntityManagerInterface $entityManager): array
    {
        $orderRepository = $entityManager->getRepository(Order::class);
        try {
            return $orderRepository->findAll();
        } catch (\Exception $exception) {
            //TODO: log the exceptions
            return [];
        }

    }
}
