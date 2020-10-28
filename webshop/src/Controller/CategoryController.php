<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/products/{id}", name="category_products")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(Request $request, CategoryRepository $categoryRepository)
    {
        $categoryId = $request->attributes->get('id');
        $category = $categoryRepository->find($categoryId);
        if (!$category) {
            return $this->redirectToRoute('home');
        }
        $products = $category->getProducts(); //TODO:querybuilder after status code update.
        return $this->render('category/products.html.twig', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
