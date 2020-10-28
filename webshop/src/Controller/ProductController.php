<?php

namespace App\Controller;

use App\Repository\ProductRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/details/{id}", name="product_details")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(Request $request, ProductRepository $productRepository)
    {
        $productId = $request->attributes->get('id');
        $product = $productRepository->find($productId); //TODO: Change query after product status codes update.
        if ($product) {
            return $this->render('product/details.html.twig', [
                'product' => $product,
            ]);
        }
        return $this->redirectToRoute('home');
    }
}
