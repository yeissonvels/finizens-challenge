<?php

namespace App\Application\portfolio;

use App\Domain\Entity\Portfolio;
use Doctrine\ORM\EntityManagerInterface;

class GetPortfolioUseCase
{
    public function execute(EntityManagerInterface $entityManager, $id): Portfolio|\Exception
    {
        $portfolioRespository = $entityManager->getRepository(Portfolio::class);
        try {
            return $portfolioRespository->findOneBy(['id' => $id]);
        } catch (\Exception $error) {
            return $error;
        }
    }
}
