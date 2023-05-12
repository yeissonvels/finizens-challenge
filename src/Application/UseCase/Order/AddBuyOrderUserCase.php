<?php

namespace App\Application\UseCase\Order;

use App\Domain\Model\Entity\Allocation;
use App\Domain\Model\Entity\Order;
use App\Domain\Model\Entity\Portfolio;
use Doctrine\ORM\EntityManagerInterface;

class AddBuyOrderUserCase
{
    public function execute(EntityManagerInterface $entityManager, $orderData): bool
    {
        $portfolioRepository = $entityManager->getRepository(Portfolio::class);
        $portfolio = $portfolioRepository->findOneBy(['id' => $orderData['portfolio']]);
        $allocation = new Allocation();
        $allocation->setShares($orderData['shares']);
        $allocation->setPortfolio($portfolio);
        $entityManager->persist($allocation);
        $entityManager->flush();

        $order = new Order();
        $order->setPortfolio($allocation->getPortfolio()->getId());
        $order->setAllocation($allocation->getId());
        $order->setShares($allocation->getShares());
        $order->setType($orderData['type']);
        $order->setCompleted(false);

        try {
            $entityManager->persist($order);
            $entityManager->flush();

            return true;
        } catch (\Exception $exception) {
            //TODO: log the exceptions
        }

        return false;
    }
}
