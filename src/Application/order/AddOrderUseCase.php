<?php

namespace App\Application\order;

use App\Domain\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

class AddOrderUseCase
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param \stdClass $data
     * @return bool
     */
    public function execute(EntityManagerInterface $entityManager, \stdClass $data): bool
    {
        $order = new Order();
        $order->setPortfolio($data->portfolio);
        $order->setAllocation($data->allocation);
        $order->setShares($data->shares);
        $order->setType($data->type);
        $order->setCompleted(false);

        try {
            $entityManager->persist($order);
            $entityManager->flush();
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
