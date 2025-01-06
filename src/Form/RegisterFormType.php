<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // Import ChoiceType
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
            ])

            ->add('genre', ChoiceType::class, [ // Changed to ChoiceType for better user input
                'label' => 'Genre',
                'required' => true,
                'choices' => [
                    'Masculin' => 'masculin',
                    'Féminin' => 'feminin',
                    'Autre' => 'autre',
                ],
                'placeholder' => 'Sélectionnez un genre',
            ])
            ->add('type', ChoiceType::class, [ // Adjusted type field
                'label' => 'Type d\'utilisateur',
                'choices' => [
                    'Conducteur' => 'conducteur',
                    'Passager' => 'passager',
                    'Admin' => 'admin',
                ],
                'required' => true,
                'placeholder' => 'Sélectionnez un type',
                'mapped' => false, // Prevent mapping to the entity
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue(['message' => 'Vous devez accepter les termes.']),
                ],
                'label' => 'Accepter les termes',
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un mot de passe']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
                'label' => 'Mot de passe',
            ])
            ->add('confirm_password', PasswordType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Confirmer le mot de passe',
            ])
            ->add('profilePic', FileType::class, [
                'label' => 'Photo de profil',
                'required' => false,
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}