<?php

namespace App\Form;

use App\Entity\Rental;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RentalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateTimeType::class,
            [
            'label' => 'Date d\'emprunt',
            'label_attr' => ['class' => 'form-label'],
            'attr' => ['class' => 'form-control'],
            ])
            ->add('endtime' , DateTimeType::class,
            [
            'label' => 'Date de retour',
            'label_attr' => ['class' => 'form-label'],
            'attr' => ['class' => 'form-control'],
            ])
            //->add('users', EntityType::class, ['class' => User::class, 'choice_label' => 'lastname'] )
            
            ->add('book',SubmitType::class,
            [
            'label' => 'Réserver',
            'attr' => ['class' => 'btn btn-outline-success']]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rental::class,
        ]);
    }
}
