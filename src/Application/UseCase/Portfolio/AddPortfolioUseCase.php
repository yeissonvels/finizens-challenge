<?php

namespace App\Application\UseCase\Portfolio;

use App\Domain\Model\Entity\Allocation;
use App\Domain\Model\Entity\Portfolio;
use Doctrine\ORM\EntityManagerInterface;

class AddPortfolioUseCase
{
    public function execute(EntityManagerInterface $entityManager): ?Portfolio
    {
        $portfolio = new Portfolio();
        // Insert the allocations
        $allocation1 = new Allocation();
        $allocation1->setShares(3);
        $allocation1->setPortfolio($portfolio);

        $allocation2 = new Allocation();
        $allocation2->setShares(4);
        $allocation2->setPortfolio($portfolio);

        $portfolio->addAllocation($allocation1);
        $portfolio->addAllocation($allocation2);

        try {
            $entityManager->persist($portfolio);
            $entityManager->flush();
            return $portfolio;
        } catch (\Exception $exception) {
            //TODO: log the exception
        }

        return null;
    }
}
