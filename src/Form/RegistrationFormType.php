<?php
// RegistrationFormType.php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

class RegistrationFormType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Please enter your first name.']),
                    new Assert\Length(['max' => 255]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'First name must contain only letters.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'e.g. John',
                ],
            ])
            ->add('lastName', null, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Please enter your last name.']),
                    new Assert\Length(['max' => 255]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Last name must contain only letters.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'e.g. Doe',
                ],
            ])
            ->add('email', null, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Please enter your email address.']),
                    new Assert\Email([
                        'message' => 'The email "{{ value }}" is not a valid email.',
                    ]),
                    new Assert\Callback([$this, 'validateUniqueEmail']),
                ],
                'attr' => [
                    'placeholder' => 'e.g. john@example.com',
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Please enter a password.']),
                    new Assert\Length(['min' => 6, 'max' => 4096]),
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirm Password',
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Please confirm your password.']),
                ],
                'attr' => [
                    'placeholder' => 'Confirm your password',
                ],
            ])
            ->add('profilePicture', FileType::class, [
                'label' => 'Profile Picture',
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Please upload your profile picture.']),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new Assert\IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'Select your role' => '',
                    'Owner' => 'ROLE_OWNER',
                    'Family Member' => 'ROLE_FAMILY_MEMBER',
                    'Healthcare Professional' => 'ROLE_HEALTHCARE_PROFESSIONAL',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Please select your role.']),
                    new Assert\Choice([
                        'choices' => ['ROLE_OWNER', 'ROLE_FAMILY_MEMBER', 'ROLE_HEALTHCARE_PROFESSIONAL'],
                    ]),
                ],
            ]);

        $isBraceletRequired = $options['bracelet_required'];

        $builder->add('bracelet', null, [
            'label' => 'Bracelet ID',
            'required' => $isBraceletRequired,
            'attr' => [
                'placeholder' => 'Enter Bracelet ID',
            ],
            'constraints' => [
                new Assert\NotBlank(['message' => 'Please enter the bracelet ID.']),
            ],
        ]);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $password = $form->get('plainPassword')->getData();
            $confirmPassword = $form->get('confirmPassword')->getData();

            if ($password !== $confirmPassword) {
                $form->get('confirmPassword')->addError(new FormError('The password fields must match.'));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'bracelet_required' => false,
            'error_mapping' => [
                // Supprime la génération automatique des messages de validation HTML5
                // pour chaque champ du formulaire
                'extraFields' => '',
            ],
        ]);
    }

    // Validation personnalisée pour vérifier si l'email est unique
    public function validateUniqueEmail($value, ExecutionContextInterface $context): void
    {
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $value]);

        if ($existingUser !== null) {
            $context->buildViolation('This email is already associated with an existing account.')
                ->atPath('email')
                ->addViolation();
        }
    }
}
