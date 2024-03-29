<?php

namespace App\Controller\Admin;

use App\Entity\Show;
use App\Entity\Location;
use App\Entity\Locality;


use App\Repository\LocalityRepository;



use App\Repository\LocationRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\LanguageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;   
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use Symfony\Component\HttpFoundation\Response;



class ShowCrudController extends AbstractCrudController
{



    
    public static function getEntityFqcn(): string
    {
        return Show::class;
    }

    public function configureCrud(Crud $crud): Crud 
    {

        return $crud 
        ->setentityLabelInPlural("Shows")
        ->setentityLabelInSingular("Show")
        ->renderContentMaximized()
       // ->renderSidebarMinimized()
       ->setPageTitle("index","Administration des show")
       // max de 10 users par page visible
       ->setPaginatorPageSize(10)

        ;
    }
    public function configureFields(string $pageName): iterable

    {
        if ($pageName === 'new') {
            // Add a success message to the flash bag
            $this->addFlash('success', 'Show created successfully. You can now create a representation.');
        }
    
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('location', 'Location'),
            AssociationField::new('artistTypes', 'Artist_Types_ID')
                ->setHelp('Selectionner un(e) Auteur, un(e) metteur en scène et un(e) disttributeur) ')
                ->setRequired(true),

                SlugField::new('slug')->setTargetFieldName('title'),
            TextField::new('title'),
            TextField::new('description'),
            TextField::new('poster_url'),
            BooleanField::new('bookable'),
            MoneyField::new('price')
            ->setCurrency('EUR')
           ->setNumDecimals(2)
           ->setStoredAsCents('true'),
         
        ];


      
    }
    
    
}
