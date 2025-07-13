<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

final class ShopController extends AbstractController
{

    /**
     * Displays a list of products, with optional filtering by category or tag.
     *
     * @param Environment $twig
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     * @param Request $request
     *
     * @return Response
     */
    #[Route('/', name: 'app_shop')]
    public function index(Environment $twig, ProductRepository $productRepository, CategoryRepository $categoryRepository, TagRepository $tagRepository, Request $request): Response
    {
        $categoryId = $request->query->getInt('category', 0);
        $tagId = $request->query->getInt('tag', 0);
        if ($tagId) {
            $tag = $tagRepository->find($tagId);
            $products = $tag ? $tag->getProductId() : [];
        } elseif ($categoryId) {
            $category = $categoryRepository->find($categoryId);
            $products = $category ? $category->getProducts() : [];
        } else {
            $products = $productRepository->findAll();
        }
        $categries = $categoryRepository->findAll();
        $tags = $tagRepository->findAll();
        return new Response($twig->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'products' => $products,
            'tags' => $tags,
            'categories' => $categries,
            'currentCategory' => $categoryId,
            'currentTag' => $tagId,
        ]));
    }
}
