<?php

namespace App\Form;

use App\Entity\BiologicalData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert; // Importer la classe Assert 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BiologicalDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('timestamp', null, [
            'attr' => [
                'placeholder' => 'e.g. Timestamp',
            ],
        ])
        ->add('measurementType', null, [
            'attr' => [
                'placeholder' => 'e.g. Measurement Type',
            ],
        ])
        ->add('value', null, [
            'attr' => [
                'placeholder' => 'e.g. Value',
            ],
        ])
        ->add('patientName', TextType::class, [
            'label' => 'Patient Name',
            'required' => true,
            'attr' => [
                'placeholder' => 'e.g. John',
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 255]),
            ],
        ])
        ->add('patientLastName', TextType::class, [
            'label' => 'Patient Last Name',
            'required' => true,
            'attr' => [
                'placeholder' => 'e.g. Doe',
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 255]),
            ],
        ])
        ->add('patientAge', IntegerType::class, [
            'label' => 'Patient Age',
            'required' => true,
            'attr' => [
                'placeholder' => 'e.g. 30',
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\PositiveOrZero(),
            ],
        ])
        ->add('medication', CollectionType::class, [
            'entry_type' => MedicationType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ])
        ->add('disease', TextareaType::class, [
            'label' => 'Disease',
            'required' => false,
            'attr' => [
                'placeholder' => 'e.g. Disease',
            ],
        ])
        ->add('otherInformation', TextareaType::class, [
            'label' => 'Other Information',
            'required' => false,
            'attr' => [
                'placeholder' => 'e.g. Other Information',
            ],
        ]);
}
}