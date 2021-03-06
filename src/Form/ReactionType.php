<?php

namespace App\Form;

use App\Entity\Reaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('legend', ChoiceType::class, [
                'choices' => [
                    Reaction::VERY_BAD => Reaction::VERY_BAD,
                    Reaction::BAD => Reaction::BAD,
                    Reaction::LIKE => Reaction::LIKE,
                    Reaction::GOOD => Reaction::GOOD,
                    Reaction::VERY_GOOD => Reaction::VERY_GOOD,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => false,
            ])
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reaction::class,
        ]);
    }
}
