<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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
            ImageField::new('pictureFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('picture')->setBasePath('/images/products')->onlyOnIndex()
        ];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = $displayCategories;
        } else {
            $fields[] = $formCategories;
        }

        return $fields;
    }

}
