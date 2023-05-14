<?php

namespace App\Form;

use App\Entity\Show;
use App\Entity\Location;
use App\Entity\ArtistType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Count;


class ShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('slug')
            ->add('title')
            ->add('description')
            ->add('poster_url')
            ->add('bookable')
            ->add('price')

            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => function (Location $location) {
                    return $location->getDesignation();
                },
            ])

            ->add('artistTypes', EntityType::class, [
                'class' => ArtistType::class,
                'choice_label' => function (ArtistType $artistType) {
                    return $artistType->getArtist()->getFirstname() . ' ' . $artistType->getArtist()->getLastName();
                },
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => 'true',
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('at')
                        ->leftJoin('at.type', 't')
                        ->join('at.artist', 'a')
                        ->orderBy('a.firstname', 'ASC')
                        ->addOrderBy('a.lastname', 'ASC')
                        ->where('t.type = :type1')
                        ->orWhere('t.type = :type2')
                        ->orWhere('t.type = :type3')
                        ->setParameters([
                            'type1' => 'scénographe',
                            'type2' => 'auteur',
                            'type3' => 'comédien',
                        ]);
                },
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner au moins un artiste.'
                    ]),
                    new Count([
                        'min' => 1,
                        'minMessage' => 'Veuillez sélectionner au moins un artiste.'
                    ]),
                ],
            ])
            /*
            ->add('representations', CollectionType::class, [
                'entry_type' => RepresentationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ])*/

            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Show::class,
        ]);
    }
}
