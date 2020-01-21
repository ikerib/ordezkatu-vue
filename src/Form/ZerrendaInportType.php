<?php

namespace App\Form;

use App\Entity\Zerrenda;
use App\Repository\ZerrendaRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZerrendaInportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('zerrenda', EntityType::class, [
                'class' => Zerrenda::class,
                'query_builder' => static function (ZerrendaRepository $zerrendaRepository) {
                    return $zerrendaRepository->getAllZerrendas();
                },
                'choice_label' => 'name',
                'placeholder' => 'Aukeratu bat'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false
        ]);
    }
}
