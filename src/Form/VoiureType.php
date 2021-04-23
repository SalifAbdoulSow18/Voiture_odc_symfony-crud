<?php

namespace App\Form;

use App\Entity\Voiture;
use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoiureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')
            ->add('annee')
            ->add('carburant')
            ->add('prix')
            ->add('kilometrage')
            ->add('dedouane')
            ->add('couleur', ColorType::class)
            ->add('personne', EntityType::class, [
                'class' => Personne::class,
                'choice_label' => function ($personne) {
                    return $personne->getPrenom()." ".$personne->getNom();
                }
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
