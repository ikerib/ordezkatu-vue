<?php

namespace App\Form;

use App\Entity\EmployeeZerrendaType;
use App\Entity\Zerrenda;
use App\Repository\EmployeeZerrendaRepository;
use App\Repository\ZerrendaRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class EmployeeZerrendaTypeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $employeeid = $options['employeeid'];

        $builder
            ->add('documentFile', VichFileType::class, [
                'label' => 'Fitxategia: ',
                'required' => false
            ])
            ->add('employee',null,[
                'label' => 'Hautagaia: ',
                'attr' => [
                    'placeholder' => 'Aukeratu bat',
                    'class' => 'myselect2',
                ]
            ])
            ->add('zerrenda', EntityType::class, [
                'class' => Zerrenda::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'query_builder' => static function(ZerrendaRepository $z) use ($employeeid) {
                    return $z->getAllZerrendasForUser($employeeid);
                },
                'placeholder' => 'Aukeratu bat',
                'label' => 'Zerrenda: ',
                'attr' => [
                    'placeholder' => 'Aukeratu bat',
                    'class' => 'myselect2',
                ]
            ])
            ->add('type', null, [
                'placeholder' => 'Aukeratu bat',
                'label' => 'Egoera: ',
                'attr' => [
                    'class' => 'myselect2',
                    'placeholder' => 'Aukeratu bat',
                ]
            ])
            ->add('notes', CKEditorType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmployeeZerrendaType::class,
            'employeeid' => null
        ]);
    }
}
