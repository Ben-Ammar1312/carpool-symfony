<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// Ajout des namespaces manquants
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lieuDepart', TextType::class, [
                'label' => 'Departure Location',
                'required' => true,
                'attr' => ['placeholder' => 'Departure Location'],
            ])
            ->add('departLat', TextType::class, [
                'required' => false,
                'mapped' => false,
            ])
            ->add('departLng', TextType::class, [
                'required' => false,
                'mapped' => false,
            ])
            ->add('lieuArrive', TextType::class, [  // Changement ici: lieuArrive -> lieuArrivee
                'label' => 'Destination',
                'required' => true,
                'attr' => ['placeholder' => 'Destination'],
            ])
            ->add('arriveLat', TextType::class, [
                'required' => false,
                'mapped' => false,
            ])
            ->add('arriveLng', TextType::class, [
                'required' => false,
                'mapped' => false,
            ])
            ->add('dateDepart', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date of Departure',
            ])
            ->add('heureDepart', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Time of Departure',
            ])
            ->add('nbrPlace', NumberType::class, [
                'label' => 'Available Seats',
                'required' => true,
                'attr' => ['min' => 1],
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Price per Passenger',
                'required' => true,
                'attr' => ['min' => 0, 'step' => 5],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
