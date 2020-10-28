<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
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
            ->disable(Action::DELETE, Action::NEW);
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            TextField::new('user')->onlyOnIndex(),
            DateTimeField::new('order_date')->onlyOnIndex(),
            ArrayField::new('orderProducts', 'Products')->onlyOnIndex(),
            NumberField::new('totalSum', 'Subtotal')->onlyOnIndex()->formatValue(function ($value){
              return $value = '$' . strval($value);
            })
        ];
    }
}
