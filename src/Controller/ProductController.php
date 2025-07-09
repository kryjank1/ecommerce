<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

final class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'product')]
    public function show(int $id, Environment $twig, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);
        return new Response($twig->render('product/show.html.twig', [
            'product' => $product,
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
