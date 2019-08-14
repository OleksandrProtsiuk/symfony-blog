<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', TextType::class, ['required' => true,
                //'constraints' => [new Length(['min' => 3,])],
                'label' => false,
                'attr' => ['placeholder' => 'Username', 'style'],
                ])
            ->add('login', TextType::class, ['required' => true,
                //'constraints' => [new Length(['min' => 3])],
                'label' => false,
                'attr' => ['placeholder' => 'Login'],
                ])
            ->add('password', PasswordType::class, ['required' => true,
                //'constraints' => [new Length(['min' => 8])],
                'label' => false,
                'attr' => ['placeholder' => 'Password'],
                ])
            //->add('role', HiddenType::class, ['data' => 'user', 'label' => false,])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
