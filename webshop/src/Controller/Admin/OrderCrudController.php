<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
use App\Repository\ProductRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Konekt\PdfInvoice\InvoicePrinter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderCrudController extends AbstractCrudController
{
    /**
     * @Route("/admin/getOrderStatus", name="order_status")
     * @param Request $request
     * @param OrderRepository $orderRepository
     * @param OrderStatusRepository $orderStatusRepository
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function orderStatus(Request $request, OrderRepository $orderRepository, OrderStatusRepository $orderStatusRepository, ProductRepository $productRepository)
    {
        $id = $request->get('id');
        $order = $orderRepository->find($id);
        if (!$order) {
            return $this->redirectToRoute('admin');
        }
        $form = $this->createFormBuilder()
            ->add('orderStatus', EntityType::class, array(
                'class' => OrderStatus::class,
                'label' => false,
                'data' => $order->getStatus(),
                'multiple' => false,
                'expanded' => false,
            ))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $orderStatus = $orderStatusRepository->find($form->get('orderStatus')->getData());
            if ($orderStatus->getName() == 'Completed') {
                if ($this->isProductInStock($order) == false) {
                    $this->addFlash('warning', 'Insufficient quantity in stock. Restock your inventory.');
                    return $this->redirectToRoute('admin');
                } else {
                    $this->sell($order, $productRepository);
                }
            }

            $order->setStatus($orderStatus);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();
            $this->addFlash('success', 'Order Status updated!');
            return $this->redirectToRoute('admin');
        }
        $list = $orderStatusRepository->findAll();
        return $this->render('/bundles/EasyAdminBundle/order_status.html.twig', [
            'order' => $order,
            'list' => $list,
            'form' =>$form->createView(),
        ]);
    }

    /**
     * @Route("/admin/print_invoice",name="print_invoice")
     * @param Request $request
     * @param OrderRepository $orderRepository
     * @param ProductRepository $productRepository
     */
    public function printInvoice(Request $request, OrderRepository $orderRepository, ProductRepository $productRepository)
    {
        $id = $request->get('id');
        $order = $orderRepository->find($id);
        if (!$order) {
            return $this->redirectToRoute('admin');
        }
        $this->print($order, $productRepository);
        return new Response(
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/admin/cancelOrder", name="cancel_order")
     * @param Request $request
     * @param OrderRepository $orderRepository
     * @param OrderStatusRepository $orderStatusRepository
     * @return Response
     */
    public function cancelOrder(Request $request, OrderRepository $orderRepository, OrderStatusRepository $orderStatusRepository)
    {
        $id = $request->get('id');
        $order = $orderRepository->find($id);
        if (!$order) {
            return $this->redirectToRoute('admin');
        }
        $orderStatus = $orderStatusRepository->findOneBy(['name'=>'Canceled']);
        $order->setStatus($orderStatus);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();
        $this->addFlash('warning', 'Order canceled!');
        return $this->redirectToRoute('admin');
    }

    private function print($order, $productRepository)
    {
        $invoice = new InvoicePrinter();
        $total = 0;
        $invoice->setType("Sale Invoice");
        $invoice->setReference($order->getId());
        $invoice->setDate(date('       M dS ,Y',time()));
        $invoice->setFrom(array("Webshop","Webshop","Vinkovacak 1","32100 Vinkovci"));
        $invoice->setTo(array($order->getUser()->getName(),$order->getUser()->getEmail(),$order->getAddress()->getAddress(),$order->getAddress()->getPostalCode() . ' ' . $order->getAddress()->getCity()));
        foreach ($order->getOrderProducts() as $item) {
            $product = $productRepository->find($item->getProduct()->getId());
            $invoice->addItem($product->getName(),$product->getDescription(),$item->getQuantity(),0,$item->getPriceOnOrderSubmit(),0,$item->getPriceOnOrderSubmit() * $item->getQuantity());
            $total += $item->getPriceOnOrderSubmit() * $item->getQuantity();
        }
        $invoice->addTotal("Total",$total);
        $invoice->addBadge("Payment on hand");
        $invoice->addTitle("Important Notice");
        $invoice->addParagraph("No item will be replaced or refunded if you don't have the invoice with you.");
        $invoice->setFooternote("Webshop");
        $invoice->render('Order'.$order->getId().'.pdf','D');
    }

    private function sell($order, $productRepository) {
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($order->getOrderProducts() as $item) {
            $product = $productRepository->find($item->getProduct()->getId());
            $product->setQuantity($item->getProduct()->getQuantity() - $item->getQuantity());
            $entityManager->persist($product);
            $entityManager->flush();
        }
    }

    private function isOrderProcessFinished($order) {
        if ($order->getStatus()->getName() == 'Completed' || $order->getStatus()->getName() == 'Canceled') {
            return true;
        }
        return false;
    }

    private function isOrderProcessComplete($order) {
        if ($order->getStatus()->getName() == 'Completed') {
            return true;
        }
        return false;
    }
    private function isOrderProcessCanceled($order) {
        if ($order->getStatus()->getName() == 'Canceled') {
            return true;
        }
        return false;
    }

    private function isProductInStock($order)
    {
        foreach ($order->getOrderProducts() as $item) {
            if ($item->getQuantity() > $item->getProduct()->getQuantity()) {
                return false;
            }
        }
        return true;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $orderStatus = Action::new('orderStatus', 'Process', 'fa fa-file-invoice')
            ->displayIf(fn ($entity) => !$this->isOrderProcessFinished($entity))
            ->linkToRoute('order_status', function (Order $entity){
                return [
                    'id' => $entity->getId()
                ];
            });

        $printInvoice = Action::new('printInvoice', 'Invoice', 'fa fa-print')
            ->displayIf(fn ($entity) => $this->isOrderProcessComplete($entity))
            ->linkToRoute('print_invoice', function (Order $entity){
                return [
                    'id' => $entity->getId()
                ];
            });

        $cancelOrder = Action::new('cancelOrder', 'Cancel', 'far fa-window-close')
            ->displayIf(fn ($entity) => !$this->isOrderProcessCanceled($entity))
            ->linkToRoute('cancel_order', function (Order $entity){
                return [
                    'id' => $entity->getId()
                ];
            });


        return $actions
            ->disable(Action::DELETE, Action::NEW, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $orderStatus)
            ->add(Crud::PAGE_INDEX, $printInvoice)
            ->add(Crud::PAGE_INDEX, $cancelOrder)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setLabel('Details');
            });
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id'),
            TextField::new('user.getEmail', 'Email')->hideOnForm(),
            TextField::new('user', 'Name')->onlyOnDetail(),
            TextField::new('getAddress', 'Address')->hideOnForm(),
            DateTimeField::new('order_date')->hideOnForm(),
            ArrayField::new('orderProducts', 'Products')->onlyOnDetail()->setSortable(false),
            NumberField::new('totalSum', 'Subtotal')->hideOnForm()->formatValue(function ($value){
                return $value = '$' . strval($value);
            }),
            TextField::new('status', 'Order Status')
        ];
    }
}