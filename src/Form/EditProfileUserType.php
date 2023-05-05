<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class EditProfileUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('login', TextType::class, ['label' => 'Identifiant'])
        ->add('firstname', TextType::class, ['label' => 'Prénom'])
        ->add('lastname', TextType::class, ['label' => 'Nom'])
        ->add('email', TextType::class, ['label' => 'E-mail'])
        ->add('language', ChoiceType::class, [
            'label' => 'Langue',
            'choices' => [
                'Anglais' => 'en',
                'Français' => 'fr'               
            ],
            'expanded' => false,
            'multiple' => false,
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        ->add('Valider', SubmitType::class)
    ;
    
    } 

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
