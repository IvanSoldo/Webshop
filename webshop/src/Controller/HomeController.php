<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\ShopRepository;
use App\Repository\StoreSettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $storeName;
    private $date;

    public function __construct(StoreSettingsRepository $settingsRepository)
    {
        $this->storeName = $settingsRepository ->getStoreName(1);
        $this->date = $settingsRepository ->getNewProductDate(1);
    }

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
            'storeName' => $this->storeName,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @param StoreSettingsRepository $settingsRepository
     * @param ShopRepository $shopRepository
     * @return Response
     */
    public function contact(StoreSettingsRepository $settingsRepository, ShopRepository $shopRepository)
    {
        $contactInfo = $settingsRepository->find(1);
        $shopList = $shopRepository->findAll();
        return $this->render('home/contact.html.twig', [
            'contact' => $contactInfo,
            'shopList' => $shopList,
        ]);
    }

    /**
     * @Route("/sale", name="home_sale")
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function sale(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $products = $productRepository->findBy([
            'product_active' => 1,
            'onDiscount' =>1,
        ]);
        $categories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'storeName' => $this->storeName,
        ]);
    }

    /**
     * @Route("/new", name="home_new")
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function new(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $products = $productRepository->getNewProducts($this->date);
        $categories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'storeName' => $this->storeName,
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



