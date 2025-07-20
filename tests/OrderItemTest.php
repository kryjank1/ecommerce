<?php

namespace App\Tests;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class OrderItemTest extends TestCase
{
    public function testGettersSetters(): void
    {
        $item = new OrderItem();

        $item->setQunatity(3);
        $item->setPriceAtPurchase(1500);

        $this->assertSame(3, $item->getQunatity());
        $this->assertSame(1500, $item->getPriceAtPurchase());

        $order = new Order();
        $product = new Product();

        $item->setOrders($order);
        $this->assertSame($order, $item->getOrders());

        $item->setProductId($product);
        $this->assertSame($product, $item->getProductId());

        $item->setOrders(null);
        $item->setProductId(null);
        $this->assertNull($item->getOrders());
        $this->assertNull($item->getProductId());
    }
}
