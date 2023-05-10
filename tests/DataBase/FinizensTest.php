<?php

namespace App\Tests\DataBase;

use App\Domain\Entity\Allocation;
use App\Domain\Entity\Order;
use App\Domain\Entity\Portfolio;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FinizensTest extends KernelTestCase
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

    /** @test */
    public function create_buy_type_order()
    {
        $order = new Order();
        $order->setPortfolio(1);
        $order->setAllocation(1);
        $order->setShares(2);
        $order->setType("buy");
        $order->setCompleted(false);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        // Make asertions
        $this->assertEquals('1', $order->getPortfolio());
        $this->assertEquals('1', $order->getAllocation());
        $this->assertEquals('2', $order->getShares());
        $this->assertEquals('buy', $order->getType());
        $this->assertEquals(false, $order->isCompleted());

    }

    /** @test */
    public function create_sell_type_order()
    {
        $order = new Order();
        $order->setPortfolio(1);
        $order->setAllocation(2);
        $order->setShares(1);
        $order->setType("sell");
        $order->setCompleted(false);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        // Make asertions
        $this->assertEquals('1', $order->getPortfolio());
        $this->assertEquals('2', $order->getAllocation());
        $this->assertEquals('1', $order->getShares());
        $this->assertEquals('sell', $order->getType());
        $this->assertEquals(false, $order->isCompleted());

    }

}
