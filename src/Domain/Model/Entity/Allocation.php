<?php

namespace App\Domain\Model\Entity;

use App\Infrastructure\Persistence\Doctrine\AllocationRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: AllocationRepository::class)]
class Allocation implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $shares = null;

    #[ORM\ManyToOne(targetEntity: 'Portfolio', inversedBy: 'allocation')]
    #[ORM\JoinColumn(name: 'portfolio_id', referencedColumnName: 'id', nullable: false)]
    private ?Portfolio $portfolio = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShares(): ?int
    {
        return $this->shares;
    }

    public function setShares(int $shares): self
    {
        $this->shares = $shares;

        return $this;
    }

    public function getPortfolio(): ?Portfolio
    {
        return $this->portfolio;
    }

    public function setPortfolio(?Portfolio $portfolio)
    {
        $portfolio->addAllocation($this);
        $this->portfolio = $portfolio;

    }


    #[Pure] #[ArrayShape(['id' => "int|null", 'shares' => "int|null"])]
    public function jsonSerialize(): array
    {
        return array(
            'id' => $this->getId(),
            'shares' => $this->getShares()
        );
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
