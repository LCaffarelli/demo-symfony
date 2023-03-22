<?php

namespace App\Form;

use App\Entity\Season;
use App\Entity\Serie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('firstAirDate')
            ->add('overview')
            ->add('poster')
            ->add('tmdbID')
            //serie ne peut pas etre lu car entité , donc on precise son type, ici EntityType. On fait aussi dans les parametres un queryBuilder pour classer par ordre alphabétique les séries
            ->add('serie', EntityType::class, ['class' => Serie::class, 'choice_label' => 'name', 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('s')->orderBy('s.name', order: 'ASC');
            }]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
