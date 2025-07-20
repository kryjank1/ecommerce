<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\Tag;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testGettersSetters(): void
    {
        $product = new Product();

        $product->setName('test');
        $product->setDescription('test product name');
        $product->setPrice(1999);
        $product->setQuantity(10);
        $product->setImage('test.png');

        $this->assertSame('test', $product->getName());
        $this->assertSame('test product name', $product->getDescription());
        $this->assertSame(1999, $product->getPrice());
        $this->assertSame(10, $product->getQuantity());
        $this->assertSame('test.png', $product->getImage());
    }
    public function testCategory(): void
    {
        $product = new Product();
        $category = new Category();

        $product->setCategory($category);
        $this->assertSame($category, $product->getCategory());
    }

    public function testOrderItem(): void
    {
        $product = new Product();
        $item = new OrderItem();

        $product->addOrderItem($item);
        $this->assertCount(1, $product->getOrderItems());
        $this->assertSame($product, $item->getProductId());
    }
    public function testTag(): void
    {
        $product = new Product();
        $tag = new Tag();

        $product->addTag($tag);
        $this->assertCount(1, $product->getTags());
        $this->assertTrue($tag->getProductId()->contains($product));
    }
}
