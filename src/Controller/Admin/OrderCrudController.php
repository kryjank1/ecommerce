<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('User_id'),
            TextField::new('status'),
            DateTimeField::new('createdAt')->hideOnForm(),

            TextField::new('name'),
            TextField::new('surname'),
            TextField::new('street'),
            TextField::new('city'),
            TextField::new('postalCode'),
            TextField::new('country'),
            TelephoneField::new('phone'),

            AssociationField::new('orderItems')->hideOnForm(),

        ];
    }
}
