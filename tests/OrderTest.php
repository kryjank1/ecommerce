<?php

namespace App\Tests;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testGettersSetters(): void
    {
        $order = new Order();
        $dateTime = new \DateTimeImmutable('2025-07-19 12:00:00');

        $order->setCreatedAt($dateTime);
        $order->setStatus('pending');
        $order->setName('John');
        $order->setSurname('Doe');
        $order->setStreet('test 123');
        $order->setCity('Test');
        $order->setPostalCode('00-001');
        $order->setCountry('Poland');
        $order->setPhone('+48123456789');


        $this->assertSame($dateTime, $order->getCreatedAt());
        $this->assertSame('pending', $order->getStatus());
        $this->assertSame('John', $order->getName());
        $this->assertSame('Doe', $order->getSurname());
        $this->assertSame('test 123', $order->getStreet());
        $this->assertSame('Test', $order->getCity());
        $this->assertSame('00-001', $order->getPostalCode());
        $this->assertSame('Poland', $order->getCountry());
        $this->assertSame('+48123456789', $order->getPhone());
    }

    public function testOrderItem(): void
    {
        $order = new Order();
        $orderItem = new OrderItem();

        $order->addOrderItem($orderItem);
        $this->assertCount(1, $order->getOrderItems());
        $this->assertSame($order, $orderItem->getOrders());

        $order->removeOrderItem($orderItem);
        $this->assertCount(0, $order->getOrderItems());
        $this->assertNull($orderItem->getOrders());
    }

    public function testUser(): void
    {
        $order = new Order();
        $user = new User();

        $order->setUserId($user);
        $this->assertSame($user, $order->getUserId());
    }
}
