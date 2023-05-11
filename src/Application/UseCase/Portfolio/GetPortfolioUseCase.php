<?php

namespace App\Application\UseCase\Portfolio;

use App\Domain\Model\Entity\Portfolio;
use Doctrine\ORM\EntityManagerInterface;

class GetPortfolioUseCase
{
    public function execute(EntityManagerInterface $entityManager, $id): Portfolio|\Exception|null
    {
        $portfolioRespository = $entityManager->getRepository(Portfolio::class);
        try {
            return $portfolioRespository->findOneBy(['id' => $id]);
        } catch (\Exception $error) {
            return $error;
        }
    }
}
