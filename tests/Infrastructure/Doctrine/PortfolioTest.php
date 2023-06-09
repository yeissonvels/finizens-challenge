<?php

namespace App\Tests\Infrastructure\Doctrine;

use App\Domain\Model\Entity\Allocation;
use App\Domain\Model\Entity\Portfolio;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PortfolioTest extends KernelTestCase
{
    /** @var EntityManagerInterface */
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        DatabasePrimer::prime($kernel);

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    /** @test */
    public function a_portfolio_record_can_be_created_in_the_database()
    {
        // Portfolio
        $portfolio = new Portfolio();

        // Allocations
        $allocation1 = new Allocation();
        $allocation1->setShares(3);
        $allocation1->setPortfolio($portfolio);

        $allocation2 = new Allocation();
        $allocation2->setShares(4);
        $allocation2->setPortfolio($portfolio);

        $this->entityManager->persist($portfolio);
        $this->entityManager->flush();

        // Portfolio respository
        $portfolioRespository = $this->entityManager->getRepository(Portfolio::class);
        $portfolioRecord = $portfolioRespository->findOneBy(['id' => $portfolio->getId()]);

        // Make asertions
        $this->assertCount('2', $portfolioRecord->getAllocations());
        $this->assertEquals('3', $portfolioRecord->getAllocations()[0]->getShares());
        $this->assertEquals('4', $portfolioRecord->getAllocations()[1]->getShares());

    }
}
