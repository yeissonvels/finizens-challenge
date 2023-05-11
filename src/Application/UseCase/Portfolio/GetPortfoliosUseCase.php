<?php

namespace App\Application\UseCase\Portfolio;

use App\Domain\Model\Entity\Portfolio;
use Doctrine\ORM\EntityManagerInterface;

class GetPortfoliosUseCase
{
    public function execute(EntityManagerInterface $entityManager): array|\Exception
    {
        $portfolioRespository = $entityManager->getRepository(Portfolio::class);
        try {
            return $portfolioRespository->findAll();
        } catch (\Exception $error) {
            return $error;
        }
    }
}
