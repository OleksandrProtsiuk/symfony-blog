<?php

namespace App\Form\Admin;

use App\Entity\User;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $passwordOptions = [
            'label' => false,
            'attr' => ['placeholder' => 'Password'],
        ];

        $recordId = $options['data']->getId();
        if (!empty($recordId)) {
            $passwordOptions['required'] = false;
            $passwordOptions['empty_data'] = $options['data']->getPassword();
        }

        $builder

            ->add('name', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => ['placeholder' => 'Username'],
                ])
            ->add('login', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => ['placeholder' => 'Login'],
                ])
            ->add('password', PasswordType::class, $passwordOptions)

            ->add('email', EmailType::class, [
                'required' => true,
                'label' => false,
                'attr' => ['placeholder' => 'Email'],
            ])
            ->add('roles', ChoiceType::class, [
                    'required' => true,
                    'label' => false,
                    'choices' => [
                        'Admin' => 'ROLE_ADMIN',
                        'User' => 'ROLE_USER',
                    ],
                ])
            ->add('verification', ChoiceType::class, [
                    'required' => true,
                    'label' => false,
                    'choices' => [
                        'Yes' => true,
                        'No' => false,
                    ],
                ]
            );

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
