<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email:',
                'label_attr' => [
                    'class' => 'm-1'
                ],
                'attr' => [
                    'class' => 'col-3'
                ]
            ])
            // ->add('roles')
            ->add('password', PasswordType::class, [
                    'label' => 'Password :',
                    'label_attr' => [
                        'class' => 'm-1'
                    ],
                    'attr' => [
                        'class' => 'col-3'
                    ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom :',
                    'label_attr' => [
                        'class' => 'm-1'
                    ],
                    'attr' => [
                        'class' => 'col-3'
                    ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom :',
                    'label_attr' => [
                        'class' => 'm-1'
                    ],
                    'attr' => [
                        'class' => 'col-3'
                    ]
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Adresse :',
                    'label_attr' => [
                        'class' => 'm-1'
                    ],
                    'attr' => [
                        'class' => 'col-3'
                    ]
            ])
            ->add('zipcode', IntegerType::class, [
                'label' => 'Code Postal :',
                    'label_attr' => [
                        'class' => 'm-1'
                    ],
                    'attr' => [
                        'class' => 'col-3'
                    ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville :',
                    'label_attr' => [
                        'class' => 'm-1'
                    ],
                    'attr' => [
                        'class' => 'col-3'
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
