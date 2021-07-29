<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class CarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Car::class;
        
    }

public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('registration'),
            AssociationField::new('fleets'),
            AssociationField::new('makes'),
            AssociationField::new('seats'),
            AssociationField::new('types'),

            NumberField::new('price'),

            TextField::new('imageFile')
            ->setFormType(VichImageType::class)
            ->hideOnIndex(),
            ImageField::new('image')
            ->setBasePath('/assets/img')
            ->onlyOnIndex()
            


            //AssociationField::new('carfleet'),
            //TextEditorField::new('description')
    //         // TextEditorField::new('description'),
        ];
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
