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
    /**
     * Show a single product page with add-to-cart form.
     *
     * @param int $id Product ID
     * @param Environment $twig
     * @param ProductRepository $productRepository Repository of products
     * @param Request $request
     * @param CartService $cartService for managing the shopping cart
     *
     * @return Response
     */
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
}
