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
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
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
            ->disable(Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setLabel('Details');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        $displayCategories = ArrayField::new('categories')->setSortable(false);
        $formCategories = AssociationField::new('categories')->onlyOnForms();
        $createProduct = Field::new('pictureFile')->setFormType(VichImageType::class)->onlyOnForms()->setRequired(true);
        $editProduct =  Field::new('pictureFile')->setFormType(VichImageType::class)->onlyOnForms();

        $fields = [
            Field::new('name')->setRequired(false),
            Field::new('price')->setRequired(false),
            Field::new('description')->setRequired(false),
            Field::new('quantity')->setRequired(false),
            BooleanField::new('product_active'),
            BooleanField::new('onDiscount'),
            Field::new('discountPercentage'),
            DateTimeField::new('createdAt')->onlyOnDetail()
        ];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = $displayCategories;
        } else {
            $fields[] = $formCategories;
        }

        if ($pageName === Crud::PAGE_NEW) {
            $fields[] = $createProduct;
        } else if ($pageName === Crud::PAGE_EDIT) {
            $fields[] = $editProduct;
        }

        return $fields;
    }

}
