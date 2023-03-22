<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SerieType extends AbstractType
{
    /*Les champs sont remplis automatiquement, il faut faire le tri dans ce que l'on veut que l'utilisateur puisse avoir acces
    Le label qui sera automatiquement créé va prendre le nom de la propriété. */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //On peut aujouter des éléments (ex:type, le nom que l'on veut donner au label )
            ->add('name',TextType::class,['label'=>'Title'])

            ->add('overview')

            //Choicetype caracterise la liste déroulante. On determnine les choix dans un tableau avec choices, puis on rentre les informations.
            //on precise s'il y a un seul ou plusieur choix possible, avec multiple. Ici un seul donc à false
            // la deuxieme valeur est le label et la premiere ce qui sera affiché à l'écran.
            ->add('status', ChoiceType::class,['choices'=>['Cancelled'=>'Cancelled', 'Ended'=>'Ended','Returning'=>'Returning'],'multiple'=>false])

            ->add('vote')

            ->add('popularity')

            ->add('genre')

            //Pour avoir un calendrier qui s'affiche et non une liste déroulante il faut préciser quelques informations, le dateType, il faut mettre deux clef, une html et une widget
            ->add('firstAirDate',DateType::class,['html5'=>true, 'widget'=>'single_text'])

            ->add('lastAirDate')

            ->add('backdrop')

            ->add('poster')

            ->add('tmdbId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
