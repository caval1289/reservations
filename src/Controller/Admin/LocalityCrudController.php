<?php

namespace App\Controller\Admin;

use App\Entity\Locality;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField; 




class LocalityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Locality::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('postal_code'),
            TextField::new('locality'),

        ];
    }
}
