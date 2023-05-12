<?php

namespace App\Tests\Infrastructure\Doctrine;

use App\Domain\Model\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderTest extends KernelTestCase
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
