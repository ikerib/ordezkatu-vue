<?php

namespace App\Form;

use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Izena',
                'required' => true,
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ])
            ->add('abizena1', null, [
                'label' => '1º Abizena',
                'required' => true,
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ])
            ->add('abizena2', null, [
                'label' => '2º Abizena',
                'required' => true,
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ])
            ->add('nan', null, [
                'label' => 'N.A.N',
                'required' => true,
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ])
            ->add('email', null, [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ])
            ->add('telefono', null, [
                'label' => 'Telefonoa',
                'required' => true,
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ])
            ->add('helbidea', null, [
                'label' => 'Helbidea',
                'required' => false,
                'attr' => [
                    'autocomplete' => 'off'
                ]
            ])
            ->add('municipio', null, [
                'label' => 'Herria',
                'required' => false,
                'attr' => [
                    'class' => 'myselect2',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
