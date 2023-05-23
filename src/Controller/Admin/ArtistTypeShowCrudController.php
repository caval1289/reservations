<?php

namespace App\Controller\Admin;

use App\Entity\ArtistTypeShow;
use App\Entity\Type;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Doctrine\DBAL\Types\Types;


class ArtistTypeShowCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ArtistTypeShow::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('artistetype', 'Artiste_Type'),
            AssociationField::new('artiste', 'Artiste'),
            AssociationField::new('show', 'Spectacle '),


        ];
    
    }
    
}
