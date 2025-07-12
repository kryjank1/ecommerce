<?php

namespace App\Controller;

use App\Form\AddToCartFormTypeForm;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

final class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'product_show')]
    public function show(int $id, Environment $twig, ProductRepository $productRepository, Request $request, CartService $cartService): Response
    {
        $product = $productRepository->find($id);
        $form = $this->createForm(AddToCartFormTypeForm::class, null, ['stock' => $product->getQuantity()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartService->add($product->getId(), $form->get('quantity')->getData());
            return $this->redirectToRoute('product_show', [
                'id' => $product->getId()
            ]);
        }

        return new Response($twig->render('product/show.html.twig', [
            'product' => $product,
            'addToCartForm' => $form->createView()
        ]));
    }
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
