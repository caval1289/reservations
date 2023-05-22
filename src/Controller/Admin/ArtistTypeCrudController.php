<?php

namespace App\Controller\Admin;

use App\Entity\ArtistType;
use App\Entity\Artist;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ArtistTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ArtistType::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('type', 'type'),
            AssociationField::new('artist', 'artist'),

        //TextField::new('title'),
        //     TextEditorField::new('description'),
         ];
    }

 
 

}
