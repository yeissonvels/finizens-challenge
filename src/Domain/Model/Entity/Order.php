<?php

namespace App\Domain\Model\Entity;

use App\Infrastructure\Persistence\Doctrine\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $portfolio = null;

    #[ORM\Column]
    private ?int $allocation = null;

    #[ORM\Column]
    private ?int $shares = null;

    #[ORM\Column(length: 10)]
    private ?string $type = null;

    #[ORM\Column]
    private ?bool $completed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPortfolio(): ?int
    {
        return $this->portfolio;
    }

    public function setPortfolio(int $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getAllocation(): ?int
    {
        return $this->allocation;
    }

    public function setAllocation(int $allocation): self
    {
        $this->allocation = $allocation;

        return $this;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function isCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "int|null", 'portfolio' => "int|null", 'allocation' => "int|null", 'shares' => "int|null", 'type' => "null|string", 'completed' => "bool|null"])]
    public function jsonSerialize(): array
    {
        return array(
            'id' => $this->id,
            'portfolio' => $this->portfolio,
            'allocation' => $this->allocation,
            'shares' => $this->shares,
            'type' => $this->type,
            'completed' => $this->completed
        );
    }
}
