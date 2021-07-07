<?php

namespace App\Form;

use App\Entity\Erantzuna;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ErantzunaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Erantzuna'
            ])
            ->add('color', ChoiceType::class, [
                'label' => 'Kolorea',
                'placeholder' => 'Aukeratu bat',
                'choices' => [
                    'border-primary' => 'border-primary',
                    'border-secondary' => 'border-secondary',
                    'border-success' => 'border-success',
                    'border-danger' => 'border-danger',
                    'border-warning' => 'border-warning',
                    'border-info' => 'border-info',
                    'border-light' => 'border-light',
                    'border-dark' => 'border-dark'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Erantzuna::class,
        ]);
    }
}
