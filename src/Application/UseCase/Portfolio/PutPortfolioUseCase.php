<?php

namespace App\Application\UseCase\Portfolio;

use App\Domain\Model\Entity\Allocation;
use App\Domain\Model\Entity\Portfolio;
use Doctrine\ORM\EntityManagerInterface;

class PutPortfolioUseCase
{
    public function execute(EntityManagerInterface $entityManager, string $id, \stdClass $data)
    {
        $portfolioRepository = $entityManager->getRepository(Portfolio::class);

        /** @var Portfolio $portfolio */
        $portfolio = $portfolioRepository->findOneBy(['id' => $id]);

        foreach ($portfolio->getAllocations() as $allocation) {
            $entityManager->remove($allocation);
            $entityManager->flush();
        }

        foreach ($data->allocations as $dataAllocation) {
            $newAllocation = new Allocation();
            $newAllocation->setId($dataAllocation->id);
            $newAllocation->setShares($dataAllocation->shares);
            $newAllocation->setPortfolio($portfolio);
            $portfolio->addAllocation($newAllocation);
        }

        // $portfolio->removeAllocations();
        $entityManager->persist($portfolio);
        $entityManager->flush();
    }
}
