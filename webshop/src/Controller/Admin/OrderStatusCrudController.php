<?php

namespace App\Controller\Admin;

use App\Entity\OrderStatus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderStatusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderStatus::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $editStatus = Action::new('Edit')
            ->displayIf(fn($entity) => !$entity->getIsPredefined())
            ->linkToCrudAction(Crud::PAGE_EDIT);

        return $actions
            ->disable(Action::DELETE)
            ->add(Crud::PAGE_INDEX, $editStatus)
            ->remove(Crud::PAGE_INDEX,Action::EDIT);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
        ];
    }
}
