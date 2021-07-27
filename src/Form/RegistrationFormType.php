<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('lastname', TextType::class, ['label' => 'Nom', 
        'label_attr' =>['class' => 'form-label'],
        'attr' =>['class' => 'form-control'],
        ])
        ->add('firstname', TextType::class, ['label' => 'Prénom',
        'label_attr' =>['class' => 'form-label'],
        'attr' =>['class' => 'form-control'],])
        ->add('birthDate',BirthdayType::class,
            ['label' => 'Date de naissance',
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
            ],
            'label_attr'=>['class' => 'form-label'],
            ])
        ->add('phone', TextType::class,['label'=> 'numéro de téléphone',
        'label_attr'=>['class' => 'form-label'],
        'attr' =>['class' => 'form-control'],
        ])
        ->add('email', TextType::class,
            ['label' => 'Email',
            'label_attr'=>['class' => 'form-label'], 
            'attr' => ['class' => 'form-control']])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Merci d\'accepter les conditions d\'utilisation.',
                    ]),
                ],
                
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', 'Merci de mettre au moins 1 majuscule et 1 minuscule')
                ],  
            ])
            ->add('Sauvegarder',SubmitType::class,
            [
            'label' => $options['button_label'],
            'attr' => ['class' => 'btn btn-outline-success']
            ]
            )  
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'button_label' =>''
        ]);
    }
}
