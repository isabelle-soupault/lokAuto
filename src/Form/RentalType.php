<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Rental;
use App\Entity\User;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RentalType extends AbstractType
{
    private $userRepository;
    public function __construct(UserRepository $userRepository, CarRepository $carRepository)
    {
        $this->userRepository = $userRepository;
        $this->carRepository = $carRepository;
    }

    //private $carRepository;
    //public function __construct(CarRepository $carRepository)
    //{
    //    $this->carRepository = $carRepository;
    //}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateTimeType::class,
            [
            'label' => 'Date d\'emprunt',
            'label_attr' => ['class' => 'form-label'],
            'attr' => ['class' => 'form-control'],
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour', 'hour' => 'Heure', 'minute' => 'Min'
            ]
            ])
            ->add('endtime' , DateTimeType::class,
            [
            'label' => 'Date de retour',
            'label_attr' => ['class' => 'form-label'],
            'attr' => ['class' => 'form-control'],
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour', 'hour' => 'Heure', 'minute' => 'Min'
            ]
            ])
            //->add('users', EntityType::class, ['class' => User::class, 'choice_label' => 'lastname'] )
            //->add('users', TextType::class, ['attr' => ['value' => $options['user']]])
            ->add('users',EntityType::class,['class' => User::class,
             'label' => 'Votre nom',
            'choice_label' => 'lastName',
            'choices' => [$this->userRepository->findOneByID($options['user'])]
            ])

            ->add('cars',EntityType::class,['class' => Car::class,
            'label' => 'Marque de la voiture',
            'choice_label' => 'makes',
            'choices' => [$this->carRepository->findOneByID($options['car'])]
            ])

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
            'user' => User::class,
            'car' => Car::class,
        ]);
    }
}
