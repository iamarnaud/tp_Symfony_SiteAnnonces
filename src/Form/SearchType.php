<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Search', TextType::Class)
            ->add('Search by area', ChoiceType::class, array('choices' => array(
                'Choose your area' => null,
                'Auvergne-Rhone-Alpes' => 'Auvergne-Rhone-Alpes',
                'Bourgogne-Franche-Comté' => 'Bourgogne-Franche-Comté',
                'Bretagne' => 'Bretagne',
                'Centre-Val de Loire' => 'Centre-Val de Loire',
                'Corse' => 'Corse',
                'Grand Est' => 'Grand Est',
                'Hauts-de-France' => 'Hauts-de-France',
                'Île-de-France' => 'Île-de-France',
                'Normandie' => 'Normandie',
                'Nouvelle-Aquitaine' => 'Nouvelle-Aquitaine',
                'Occitanie' => 'Occitanie',
                'Pays de la Loire' => 'Pays de la Loire',
                "Provence-Alpes-Côte d'Azur" => "Provence-Alpes-Côte d'Azur")))
            ->add('Search by category', ChoiceType::class, array('choices' => array(
                'Choose your category' => null,
                'Enfance' => 'Enfance',
                'Immobilier' => 'Immobilier',
                'Loisirs' => 'Loisirs',
                'Maison et Jardin' => 'Maison et Jardin',
                'Matériel professionnel' => 'Matériel professionnel',
                'Mode' => 'Mode',
                'Multimedia' => 'Multimedia',
                'Service' => 'Service',
                'Vacances' => 'Vacances',
                'Véhicules' => 'Véhicules')))
            ->add("search", SubmitType::class, ["label" => "search"]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
