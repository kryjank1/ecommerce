<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

final class ShopController extends AbstractController
{
    #[Route('/', name: 'app_shop')]
    public function index(Environment $twig, ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return new Response($twig->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'products' => $products,
        ]));
    }
}
