<?php

namespace App\Form;

use App\Entity\Bracelet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BraceletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('identificationCode')
            ->add('temperature')
            ->add('bloodPressure')
            ->add('heartRate')
            ->add('movement')
            ->add('gps')
            ->add('latitude')
            ->add('longitude')
            ->add('biologicalData')
            ->add('alert')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bracelet::class,
        ]);
    }
}
