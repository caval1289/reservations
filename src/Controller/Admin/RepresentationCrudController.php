<?php

namespace App\Controller\Admin;

use App\Entity\Representation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use IntlCalendar;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class RepresentationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Representation::class;
    }

 
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('the_show', 'The Show Id')->autocomplete(),
            AssociationField::new('the_location', 'Location')->autocomplete(),
            DateTimeField::new('schedule', 'Schedule')
            ->setFormTypeOptions([
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'js-flatpickr'],
            ])
            ->setCustomOption('widget', 'single_text')
            ->setCustomOption('format', 'yyyy-MM-dd HH:mm:ss')
            ->setCustomOption('locale', 'fr')
            ->setRequired(true)
          //TextField::new('schedule'),
      
        ];
      
    }
    
}
