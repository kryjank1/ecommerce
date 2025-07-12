<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{

    public function __construct(private RequestStack $requestStack, private ProductRepository $productRepository) {}
    /**
     * adds product to the cart;
     * @param int $productId the id of product
     * @param int $quantity quantity of product to set
     */
    public function add(int $productId, int $quantity): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        $cart[$productId] = ($cart[$productId] ?? 0) + $quantity;
        $session->set('cart', $cart);
    }
    /**
     * sets/updates product in the cart;
     * @param int $productId the id of product
     * @param int $quantity quantity of product to set
     */
    public function set(int $productId, int $quantity): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        $cart[$productId] = $quantity;
        $session->set('cart', $cart);
    }

    /**
     * removes product from the car completly.
     * @param int $productId id of the product to remove
     */
    public function remove(int $productId): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        unset($cart[$productId]);
        $session->set('cart', $cart);
    }

    public function clear(): void
    {
        $this->requestStack->getSession()->remove('cart');
    }

    /*
    *
    * returns a detailed array of products and its quantities in the cart
    * @return array<int, array<string, mixed>>
    */
    public function getFullCart(): array
    {
        $cart = [];
        foreach ($this->requestStack->getSession()->get('cart', []) as $productId => $productQuantity) {
            $product = $this->productRepository->find($productId);

            if (!$product) {
                continue;
            }

            $cart[] = [
                'product' => $product,
                'quantity' => $productQuantity
            ];
        }
        return $cart;
    }

    /*
    * returns a total price of items in cart
    * @return int $total
    */
    public function getTotal(): int
    {
        $total = 0;

        foreach ($this->getFullCart() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
}
