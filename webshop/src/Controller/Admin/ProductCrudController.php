<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE);
    }

    public function configureFields(string $pageName): iterable
    {
        $displayCategories = ArrayField::new('categories');
        $formCategories = AssociationField::new('categories')->onlyOnForms();

        $fields = [
            Field::new('name'),
            Field::new('price'),
            Field::new('description'),
            Field::new('quantity'),
            BooleanField::new('product_active'),
            BooleanField::new('onDiscount'),
            Field::new('discountPercentage'),
            Field::new('pictureFile')->setFormType(VichImageType::class)->onlyWhenCreating(),

        ];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = $displayCategories;
        } else {
            $fields[] = $formCategories;
        }

        return $fields;
    }

}
