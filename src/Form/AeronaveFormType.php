<?php

namespace App\Form;

use App\Entity\Aeronave;
use App\Entity\Propietario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AeronaveFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('modelo')
            ->add('fecha_construccion', DateType::class, [
                'widget' => 'single_text',
                'years' => range(1900, date('Y')),
            ])
            ->add('apodo')
            ->add('propietario', EntityType::class, [
                'class' => Propietario::class,
                'choice_label' => 'nombre',
            ])
            ->add('imagen', FileType::class, [
                'label' => 'Imagen de la aeronave (opcional)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('guardar' , SubmitType::class, ['label' => 'Guardar'])
            ->add('cancelar' , SubmitType::class, ['label' => 'Cancelar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aeronave::class,
        ]);
    }
}
