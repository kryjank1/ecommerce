<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Form\CheckoutTypeForm;
use App\Service\CartService;
use DateTimeImmutable;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(Request $request, CartService $cartService, EntityManagerInterface $entityManager): Response
    {
        if (empty($cartService->getFullCart())) {
            $this->addFlash('warning', 'Your cart is empty.');
            return $this->redirectToRoute('app_cart');
        }
        $order = new Order();
        $form = $this->createForm(CheckoutTypeForm::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()) {
                $order->setUserId($this->getUser());
            }
            $order->setStatus("Pending");
            $order->setCreatedAt(new DateTimeImmutable());

            $entityManager->persist($order);

            foreach ($cartService->getFullCart() as $item) {
                $orderItem = new OrderItem();
                $orderItem->setOrders($order);
                $orderItem->setProductId($item['product']);
                $orderItem->setQunatity($item['quantity']);
                $orderItem->setPriceAtPurchase($item['product']->getPrice());
                $product = $item['product'];
                $newStock = $product->getQuantity() - $item['quantity'];
                if ($newStock < 0) {
                    throw new Exception("Product '{$product->getName()}' is out of stock!");
                }
                $product->setQuantity($newStock);
                $entityManager->persist($orderItem);
                $entityManager->persist($product);
                $order->addOrderItem($orderItem);
            }
            $entityManager->flush();

            $cartService->clear();

            return $this->redirectToRoute('app_cart');
        }
        return $this->render('checkout/index.html.twig', [
            'checkoutForm' => $form->createView(),
        ]);
    }
}
