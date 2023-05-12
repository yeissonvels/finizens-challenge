<?php

namespace App\Application\UseCase\Portfolio;

use App\Domain\Model\Entity\Portfolio;
use Doctrine\ORM\EntityManagerInterface;

class GetPortfoliosUseCase
{
    public function execute(EntityManagerInterface $entityManager): array|null
    {
        $portfolioRespository = $entityManager->getRepository(Portfolio::class);
        try {
            return $portfolioRespository->findAll();
        } catch (\Exception $error) {
            //TODO: log the exception
        }
        
        return null;
    }
}
