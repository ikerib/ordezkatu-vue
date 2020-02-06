<?php

namespace App\Form;

use App\Entity\Arrazoia;
use App\Entity\Job;
use App\Entity\Saila;
use App\Entity\User;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jobType', EntityType::class,[
                'class' => \App\Entity\JobType::class,
                'label' => 'Eskaera mota',
                'placeholder' =>'Aukeratu bat',
                'required' => true,
                'attr' => [
                    'class' => 'myselect2'
                ]
            ])
            ->add('saila', EntityType::class, [
                'class' => Saila::class,
                'placeholder' => 'Aukeratu bat',
                'required' => true,
                'attr' => [
                    'class' => 'myselect2'
                ]
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'label' => 'Tramitatzailea',
                'placeholder' => 'Tramitatzailea',
                'required' => true,
                'disabled' => true
            ])
            ->add('arrazoia', EntityType::class, [
                'class' => Arrazoia::class,
                'label' => 'Arrazoia / Motivo',
                'placeholder' => 'Aukeratu bat',
                'required' => true,
                'attr' => [
                    'class' => 'myselect2'
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Lanpostua / Puesto de trabajo',
                'required' => true
            ])
            ->add('startDate', TextType::class, [
                'label' => 'Hasiera / Comienzo',
                'required' => true,
                'attr' => [
                    'class' => 'datepicker col-md-6'
                ]
            ])
            ->add('endDate', TextType::class, [
                'label' => 'Bukaera / Fin',
                'required' => true,
                'attr' => [
                    'class' => 'datepicker col-md-6'
                ]
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Azalpenak / Petición detallada',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('created', DateTimeType::class, [
                'label' => 'Eskaera data / Fecha de solicitud',
                'disabled' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
