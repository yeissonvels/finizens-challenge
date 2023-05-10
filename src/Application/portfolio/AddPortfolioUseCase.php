<?php

namespace App\Application\portfolio;

use App\Domain\Entity\Allocation;
use App\Domain\Entity\Portfolio;
use Doctrine\ORM\EntityManagerInterface;

class AddPortfolioUseCase
{
    public function execute(EntityManagerInterface $entityManager): Portfolio
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

        $entityManager->persist($portfolio);
        $entityManager->flush();

        return $portfolio;
    }
}
