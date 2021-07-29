<?php

namespace App\Controller\Admin;

use App\Entity\Rental;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class RentalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rental::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            
            DateField::new('startDate'),
            DateField::new('endtime'),
            AssociationField::new('users'),
            AssociationField::new('cars')

        ];
    }

}
