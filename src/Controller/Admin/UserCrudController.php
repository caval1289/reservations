<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;



class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud 
    {

        return $crud 
        ->setentityLabelInPlural("Utilisateurs")
        ->setentityLabelInSingular("Utilisateur")
        ->renderContentMaximized()
       // ->renderSidebarMinimized()
       ->setPageTitle("index","Administration des utilisateurs")
       // max de 10 users par page visible
       ->setPaginatorPageSize(10)

        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('email')
            ->setFormTypeOption('disabled','disabled'),
            ArrayField::new('roles'),
            TextField::new('password')
            ->hideOnForm(),
            TextField::new('login'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('language'),
            BooleanField::new('is_verified'), 

  //          DateTimeField::new('createdAt'),
      //      TextEditorField::new('description'),



        ];
    }
    
}
