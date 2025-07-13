<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'tags')]
    private Collection $productId;

    public function __construct()
    {
        $this->productId = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name ?? "Unnamed tag";
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductId(): Collection
    {
        return $this->productId;
    }

    public function addProductId(Product $productId): static
    {
        if (!$this->productId->contains($productId)) {
            $this->productId->add($productId);
        }

        return $this;
    }

    public function removeProductId(Product $productId): static
    {
        $this->productId->removeElement($productId);

        return $this;
    }
}
