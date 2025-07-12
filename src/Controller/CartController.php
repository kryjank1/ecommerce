<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cartService): Response
    {
        $cartItems = $cartService->getFullCart();
        $total = $cartService->getTotal();
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'total' => $total,
            'cartItems' => $cartItems
        ]);
    }
    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function removeItem(CartService $cartService, int $id): Response
    {
        $cartService->remove($id);
        return $this->redirectToRoute('app_cart');
    }
    #[Route('cart/clear', name: 'cart_clear')]
    public function clearCart(CartService $cartService): Response
    {
        $cartService->clear();
        return $this->redirectToRoute('app_cart');
    }
}
