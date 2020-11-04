<?php

namespace App\Controller\Admin;

use App\Entity\Shop;
use App\Form\AddressType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class ShopCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Shop::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $formFields = [
            TextField::new('email')->setRequired(false)->setCssClass('row justify-content-md-center')->onlyOnForms(),
            TextField::new('address')->setFormType(AddressType::class)->setFormTypeOptions(['label' => false])->setCssClass('row justify-content-md-center')->onlyOnForms(),
        ];
        $displayFields = [
            TextField::new('email'),
            TextField::new('address')
        ];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields = $displayFields;
        } else {
            $fields = $formFields;
        }

        return $fields;
    }

}
