<?php

namespace App\Form;

use App\Entity\Conducteur;use assets\Entity\Annonce;use Symfony\Bridge\Doctrine\Form\Type\EntityType;use Symfony\Component\Form\AbstractType;use Symfony\Component\Form\FormBuilderInterface;use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDepart', null, [
                'widget' => 'single_text',
            ])
            ->add('nbrPlace')
            ->add('lieuDepart')
            ->add('lieuArrive')
            ->add('heureDepart')
            ->add('description')
            ->add('aller_retour')
            ->add('regulier')
            ->add('prix')
            ->add('conducteur', EntityType::class, [
                'class' => Conducteur::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
