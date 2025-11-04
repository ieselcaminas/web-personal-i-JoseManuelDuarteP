<?php

namespace App\Form;

use App\Entity\Propietario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropietarioFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('telefono')
            ->add('edad')

            ->add('guardar', SubmitType::class, ['label' => 'Guardar'])
            ->add('cancelar', SubmitType::class, ['label' => 'Cancelar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Propietario::class,
        ]);
    }
}
