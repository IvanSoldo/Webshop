<?php

namespace App\Controller;

use App\Entity\CartProduct;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Form\AddressType;
use App\Repository\CartProductRepository;
use App\Repository\OrderStatusRepository;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
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
            $this->addFlash('success', 'Quantity changed!');
            return $this->redirectToRoute('home');
        }
        $entityManager->persist($cartItem);
        $entityManager->flush();
        $this->addFlash('success', 'Added to cart!');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/cart/incrementQuantity/{id}", name="cart_item_add")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param CartProductRepository $cartProductRepository
     * @return RedirectResponse
     */
    public function incrementQuantity(Request $request, ProductRepository $productRepository, CartProductRepository $cartProductRepository)
    {
        $productId = $request->attributes->get('id');
        $product = $productRepository->find($productId);
        $cartItem = $cartProductRepository->findOneBy([
           'cart' => $this->getUser()->getCart(),
           'product' => $product,
        ]);
        if ($cartItem) {
            $entityManager = $this->getDoctrine()->getManager();
            $cartItem->setQuantity($cartItem->getQuantity() + 1);
            $entityManager->flush();
            $this->addFlash('success', 'Quantity changed!');
            return $this->redirectToRoute('cart');
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/cart/decrementQuantity/{id}", name="cart_item_remove")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param CartProductRepository $cartProductRepository
     * @return RedirectResponse
     */
    public function decrementQuantity(Request $request, ProductRepository $productRepository, CartProductRepository $cartProductRepository)
    {
        $productId = $request->attributes->get('id');
        $cartItem = $cartProductRepository->findOneBy([
            'cart' => $this->getUser()->getCart(),
            'product' => $productRepository->find($productId),
        ]);
        if ($cartItem) {
            $entityManager = $this->getDoctrine()->getManager();
            $cartItem->setQuantity($cartItem->getQuantity() - 1);
            if ($cartItem->getQuantity() <= 0) {
                $entityManager->remove($cartItem);
            }
            $entityManager->flush();
            return $this->redirectToRoute('cart');
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/cart/deleteFromCart/{id}", name="cart_item_delete")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param CartProductRepository $cartProductRepository
     * @return RedirectResponse
     */
    public function deleteFromCart(Request $request, ProductRepository $productRepository, CartProductRepository $cartProductRepository)
    {
        $productId = $request->attributes->get('id');
        $cartItem = $cartProductRepository->findOneBy([
            'cart' => $this->getUser()->getCart(),
            'product' => $productRepository->find($productId),
        ]);
        if ($cartItem) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cartItem);
            $entityManager->flush();
            $this->addFlash('danger', 'Item removed from cart!');
            return $this->redirectToRoute('cart');
        }
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/checkout", name="cart_checkout")
     * @param Request $request
     * @param OrderStatusRepository $orderStatusRepository
     * @return RedirectResponse|Response
     */
    public function checkoutController(Request $request, OrderStatusRepository $orderStatusRepository) {

        $form = $this->createForm(AddressType::class);
        $form->handleRequest($request);

        $products = $this->getUser()->getCart()->getCartProducts();

        if (count($products) == 0) {
            return $this->redirectToRoute('home');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->submitOrder($form, $products,$orderStatusRepository);
            $this->emptyCart($products);
            $this->addFlash('success', 'Order Submitted!');
            return $this->redirectToRoute('home');
        }

        return $this->render('cart/checkout.html.twig', [
            'products' => $products,
            'user' => $this->getUser(),
            'addressForm'=> $form->createView(),
        ]);
    }

    private function submitOrder($form, $products, $orderStatusRepository) {
        $user = $this->getUser();
        $order = new Order();
        $orderStatus = $orderStatusRepository->findOneBy([
            'name' => 'Submitted',
        ]);
        $order->setStatus($orderStatus);
        $order->setAddress($form->getData());
        $order->setUser($user);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();
        foreach ($products as $product) {
            $orderProduct = new OrderProduct();
            $orderProduct->setProduct($product->getProduct());
            $orderProduct->setQuantity($product->getQuantity());
            $orderProduct->setOrders($order);
            if ($product->getProduct()->getOnDiscount()) {
                $orderProduct->setPriceOnOrderSubmit($product->getProduct()->getDiscountedPrice());
            } else {
                $orderProduct->setPriceOnOrderSubmit($product->getProduct()->getPrice());
            }
            $entityManager->persist($orderProduct);
            $entityManager->flush();
        }
    }

    private function emptyCart($products) {
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($products as $product) {
            $entityManager->remove($product);
            $entityManager->flush();
        }
    }
}
