<?php

namespace App\Form;

use App\Entity\Representation;
use App\Entity\Show;
use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepresentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('schedule')
            ->add('the_show', EntityType::class, [
                'class' => Show::class,
                'choice_label' => 'title',
            ])
            ->add('the_location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'designation',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Representation::class,
        ]);
    }
}