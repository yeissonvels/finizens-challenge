<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\PortfolioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: PortfolioRepository::class)]
class Portfolio implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'portfolio', targetEntity: Allocation::class, cascade: ["persist"], fetch: 'EAGER')]
    private Collection $allocations;

    #[Pure] public function __construct()
    {
        $this->allocations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Allocation>
     */
    public function getAllocations(): Collection
    {
        return $this->allocations;
    }

    public function addAllocation(Allocation $allocation)
    {
        if (!$this->allocations->contains($allocation)) {
            $this->allocations->add($allocation);
        }
    }

    public function removeAllocation(Allocation $allocation)
    {
        if ($this->allocations->contains($allocation)) {
            $this->allocations->remove($allocation);
        }
    }

    public function removeAllocations()
    {
        foreach ($this->allocations as $allocation) {
            $this->removeAllocation($allocation);
        }
    }


   #[Pure] #[ArrayShape(['allocations' => "mixed", 'id' => "int|null"])]
   public function jsonSerialize(): array
   {
       $allocations = [];
       foreach ($this->getAllocations() as $allocation) {
           $allocations[] = json_decode(json_encode($allocation));
       }

       return array(
           'allocations' => $allocations,
           'id' => $this->getId()
       );
   }
}
