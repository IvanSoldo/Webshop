<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $products = $productRepository->findBy([
            'product_active' => 1,
        ]);
        $categories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/home/search", name="search")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function search(Request $request, ProductRepository $productRepository)
    {
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);
        $products ='';

        if ($form->isSubmitted() && !$form->isEmpty()) {
            $products = $productRepository->searchProductsByName($form['query']->getData());

            if (count($products) == 0) {
                $this->addFlash('warning', 'No products found');
            }
            return $this->render('home/search.html.twig', [
                'form' => $form->createView(),
                'products' => $products,
            ]);
        }

        return $this->render('home/search.html.twig', [
            'form' => $form->createView(),
            'products'=> $products,
        ]);
    }
}



