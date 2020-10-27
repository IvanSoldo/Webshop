<?php

namespace App\Controller;

use App\Entity\CartProduct;
use App\Repository\CartProductRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index()
    {
        $products = $this->getUser()->getCart()->getCartProducts();
        return $this->render('cart/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param CartProductRepository $cartProductRepository
     * @return RedirectResponse
     */
    public function addToCart(Request $request, ProductRepository $productRepository, CartProductRepository $cartProductRepository)
    {
        if ($this->getUser()) {
            $productId = $request->attributes->get('id');
            $product = $productRepository->find($productId);
            $cart = $this->getUser()->getCart();
            $cartItem = new CartProduct();
            $cartItem->setCart($cart);
            $cartItem->setProduct($product);
            $entityManager = $this->getDoctrine()->getManager();

            $cartItemExists = $cartProductRepository->findOneBy([
                'cart' => $cart,
                'product' => $product
            ]);
            if ($cartItemExists) {
                $cartItemExists->setQuantity($cartItemExists->getQuantity() + 1);
                $entityManager->flush();
                $this->addFlash('success', 'Added to cart!');
                return $this->redirectToRoute('home');
            }
            $entityManager->persist($cartItem);
            $entityManager->flush();
            $this->addFlash('success', 'Added to cart!');
            return $this->redirectToRoute('home');
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/cart", name="cart_item_edit")
     */
    public function editCart(Request $request)
    {

    }
}
