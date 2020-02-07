<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\Zerrenda;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobZerrendaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('z', EntityType::class, [
                'class' =>Zerrenda::class,
                'label' => 'Zerrenda bat aukeratu',
                'required' => true,
                'placeholder' => 'Aukeratu bat'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
