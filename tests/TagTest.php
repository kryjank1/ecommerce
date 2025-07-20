<?php

namespace App\Tests;

use App\Entity\Product;
use App\Entity\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function testGettersSetters(): void
    {
        $tag = new Tag();

        $tag->setName('Headphones');
        $this->assertSame('Headphones', $tag->getName());

        $product = new Product();
        $tag->addProductId($product);

        $this->assertCount(1, $tag->getProductId());
        $this->assertTrue($tag->getProductId()->contains($product));

        $tag->removeProductId($product);
        $this->assertCount(0, $tag->getProductId());
    }
}
