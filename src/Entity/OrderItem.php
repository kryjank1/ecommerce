<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $qunatity = null;

    #[ORM\Column]
    private ?int $priceAtPurchase = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $orders = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    private ?Product $productId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQunatity(): ?int
    {
        return $this->qunatity;
    }

    public function setQunatity(int $qunatity): static
    {
        $this->qunatity = $qunatity;

        return $this;
    }

    public function getPriceAtPurchase(): ?int
    {
        return $this->priceAtPurchase;
    }

    public function setPriceAtPurchase(int $priceAtPurchase): static
    {
        $this->priceAtPurchase = $priceAtPurchase;

        return $this;
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    public function getProductId(): ?Product
    {
        return $this->productId;
    }

    public function setProductId(?Product $productId): static
    {
        $this->productId = $productId;

        return $this;
    }
}
