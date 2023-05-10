<?php

namespace App\Application\order;

use App\Domain\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

class GetPortfolioOrdersUseCase
{
    public function execute(EntityManagerInterface $entityManager, int $portfolioId): ?array
    {
        $orderRepository = $entityManager->getRepository(Order::class);
        try {
            return $orderRepository->findBy(['portfolio' => $portfolioId]);
        } catch (\Exception $exception) {
            return null;
        }

    }
}
