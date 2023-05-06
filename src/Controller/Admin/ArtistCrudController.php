<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
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


class ArtistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Artist::class;
    }

    public function configureCrud(Crud $crud): Crud 
    {

        return $crud 
        ->setentityLabelInPlural("Artists")
        ->setentityLabelInSingular("Artist")
        ->renderContentMaximized()
       // ->renderSidebarMinimized()
       ->setPageTitle("index","Administration des artists")
       // max de 10 users par page visible
       ->setPaginatorPageSize(10)

        ;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            // ->setFormTypeOption('disabled','disabled'),
            TextField::new('firstname'),
            TextField::new('lastname'),

        ];
    }
    
}
