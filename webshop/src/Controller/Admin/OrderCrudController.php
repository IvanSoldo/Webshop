<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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
     * @return Response
     */
    public function orderStatus(Request $request, OrderRepository $orderRepository, OrderStatusRepository $orderStatusRepository)
    {

        $id = $request->get('id');

        $order = $orderRepository->find($id);

        if (!$order) {
            return $this->redirectToRoute('admin');
        }

        $form = $this->createFormBuilder()
            ->add('orderStatus', EntityType::class, array(
                // query choices from this entity
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

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {

        $orderStatus = Action::new('orderStatus', 'Process order', 'fa fa-file-invoice')
            //->displayIf(fn ($entity) => !$this->isOrderProcessFinished($entity))
            ->linkToRoute('order_status', function (Order $entity){
                return [
                    'id' => $entity->getId()
                ];
            });

        return $actions
            ->disable(Action::DELETE, Action::NEW, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $orderStatus)
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
            ArrayField::new('orderProducts', 'Products')->hideOnForm()->setSortable(false),
            NumberField::new('totalSum', 'Subtotal')->hideOnForm()->formatValue(function ($value){
                return $value = '$' . strval($value);
            }),
            TextField::new('status.getName', 'Order Status')
        ];
    }
}