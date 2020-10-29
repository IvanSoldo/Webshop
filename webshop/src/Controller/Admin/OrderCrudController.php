<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->disable(Action::DELETE, Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setLabel('Details');
            });
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            TextField::new('user.getEmail', 'Email')->hideOnForm(),
            TextField::new('user', 'Name')->onlyOnDetail(),
            TextField::new('getAddress', 'Address')->hideOnForm(),
            DateTimeField::new('order_date')->hideOnForm(),
            ArrayField::new('orderProducts', 'Products')->hideOnForm()->setSortable(false),
            NumberField::new('totalSum', 'Subtotal')->hideOnForm()->formatValue(function ($value){
              return $value = '$' . strval($value);
            })
        ];
    }
}
