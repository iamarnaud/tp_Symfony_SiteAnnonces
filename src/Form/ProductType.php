<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('photo', FileType::class, array("label" => 'photo (jpg or png file)', "data_class"=>null))
            ->add('area', ChoiceType::class, array('choices' => array(
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
            ->add('category', ChoiceType::class, array('choices' => array(
                'Choose your category' => null,
                'Enfance' => 'Enfance',
                'Immobilier' => 'Immobilier',
                'Loisirs' => 'Loisirs',
                'Maison et Jardin' =>'Maison et Jardin',
                'Matériel professionnel' => 'Matériel professionnel',
                'Mode' => 'Mode',
                'Multimedia' => 'Multimedia',
                'Service' => 'Service',
                'Vacances' => 'Vacances',
                'Véhicules' => 'Véhicules'
                )))
            ->add('price')
            ->add('releaseOn');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
