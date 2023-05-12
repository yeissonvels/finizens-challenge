<?php

namespace App\Application\UseCase\Order;

use App\Domain\Model\Entity\Allocation;
use App\Domain\Model\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

class AddSellOrderUserCase
{
    public function execute(EntityManagerInterface $entityManager, $orderData): bool
    {
        $allocationRepository = $entityManager->getRepository(Allocation::class);
        try {
            /** @var Allocation $allocation */
            $allocation = $allocationRepository->findOneBy(['id' => $orderData['allocation']]);
            $order = new Order();
            $order->setPortfolio($allocation->getPortfolio()->getId());
            $order->setAllocation($allocation->getId());
            $order->setShares($allocation->getShares());
            $order->setType($orderData['type']);
            $order->setCompleted(false);
            $entityManager->persist($order);
            $entityManager->flush();

            return true;
        } catch (\Exception $exception) {
            //TODO: log the exceptions
        }
        
        return false;
    }
}
