<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    /**
     * The unique identifier for the order.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    /**
     * Timestamp when the order was created.
     *
     * @var \DateTimeImmutable|null
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;
    /**
     * Current status of the order (e.g. "pending", "shipped").
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $status = null;
    /**
     * First name of the customer who placed the order.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;
    /**
     * Last name of the customer who placed the order.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $surname = null;
    /**
     * Street address for order delivery.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $street = null;
    /**
     * City for order delivery.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $city = null;
    /**
     * Postal code for order delivery.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $postalCode = null;
    /**
     * Country for order delivery.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $country = null;
    /**
     * Contact phone number for the order.
     *
     * @var string|null
     */
    #[ORM\Column(length: 25)]
    private ?string $phone = null;
    /**
     * Items included in this order.
     *
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'orders', orphanRemoval: true)]
    private Collection $orderItems;
    /**
     * The user who placed this order.
     *
     * @var User|null
     */
    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $User_id = null;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }
    /**
     * String representation of the order.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setOrders($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrders() === $this) {
                $orderItem->setOrders(null);
            }
        }

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->User_id;
    }

    public function setUserId(?User $User_id): static
    {
        $this->User_id = $User_id;

        return $this;
    }
}
