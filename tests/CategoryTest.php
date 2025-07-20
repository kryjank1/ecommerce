<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testGettersSetters(): void
    {
        $category = new Category();

        $category->setName('Test');
        $this->assertSame('Test', $category->getName());
    }
    public function testProduct(): void
    {
        $category = new Category();
        $product = new Product();

        $category->addProduct($product);

        $this->assertCount(1, $category->getProducts());
        $this->assertSame($category, $product->getCategory());

        $category->removeProduct($product);
        $category->removeProduct($product);

        $this->assertCount(0, $category->getProducts());
        $this->assertNull($product->getCategory());
    }
}
