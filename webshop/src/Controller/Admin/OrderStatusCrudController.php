<?php

namespace App\Controller\Admin;

use App\Entity\OrderStatus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderStatusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderStatus::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
