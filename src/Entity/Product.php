<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    /**
     * The unique identifier for the product.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\NotBlank(message: "Product id cannot be blank.")]
    private ?int $id = null;
    /**
     * The name of the product.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Product name cannot be blank.")]
    private ?string $name = null;

    /**
     * A detailed description of the product.
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;
    /**
     * The price of the product (in cents).
     *
     * @var int|null
     */
    #[ORM\Column]
    #[Assert\NotNull(message: "Price must be provided.")]
    #[Assert\GreaterThanOrEqual(0, message: "Price must be zero or positive.")]
    private ?int $price = null;
    /**
     * The available quantity of the product in stock.
     *
     * @var int|null
     */
    #[ORM\Column]
    #[Assert\NotNull(message: "Quantity is required.")]
    #[Assert\GreaterThanOrEqual(0, message: "Quantity cannot be negative.")]
    private ?int $quantity = null;

    /**
     * The category this product belongs to.
     *
     * @var Category|null
     */
    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;
    /**
     * The order items associated with this product.
     *
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'productId')]
    private Collection $orderItems;
    /**
     * The tags associated with this product.
     *
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'productId')]
    #[ORM\JoinTable(name: 'product_tag')]
    private Collection $tags;
    /**
     * Path to the product image (optional).
     *
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;


    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }
    /**
     * Returns the string representation of the product.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->name ?? "Unnamed Product";
    }

    /**
     * Gets the product ID.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * Gets the product name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    /**
     * Sets the product name.
     *
     * @param string $name
     * @return static
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
    /**
     * Gets the product description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
    /**
     * Sets the product description.
     *
     * @param string $description
     * @return static
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
    /**
     * Gets the product price (in smallest currency unit like cents).
     *
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * Sets the product price (in smallest currenct unit like cents)
     *
     * @param int $price
     * @return static
     */
    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }
    /**
     * Gets the available quantity of the product.
     *
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }
    /**
     * Sets the quantity of the product.
     *
     * @param int $quantity
     * @return static
     */
    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
    /**
     * Gets the category this product belongs to.
     *
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }
    /**
     * Sets the product category.
     *
     * @param Category|null $category
     * @return static
     */
    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }
    /**
     * Adds an order item.
     *
     * @param OrderItem $orderItem
     * @return static
     */
    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setProductId($this);
        }

        return $this;
    }
    /**
     * Removes an order item.
     *
     * @param OrderItem $orderItem
     * @return static
     */
    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getProductId() === $this) {
                $orderItem->setProductId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }
    /**
     * Adds a tag to this product.
     *
     * @param Tag $tag
     * @return static
     */
    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addProductId($this);
        }

        return $this;
    }
    /**
     * Removes a tag from this product.
     *
     * @param Tag $tag
     * @return static
     */
    public function removeTag(Tag $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeProductId($this);
        }

        return $this;
    }
    /**
     * Gets the image path or filename.
     *
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Sets the image path or filename.
     *
     * @param string|null $image
     * @return static
     */
    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
