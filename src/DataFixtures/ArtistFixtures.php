<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Artist;

class ArtistFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $artists = [
            ['firstname'=>'Daniel','lastname'=>'Marcelin'],
            ['firstname'=>'Philippe','lastname'=>'Laurent'],
            ['firstname'=>'Marius','lastname'=>'Von Mayenburg'],
            ['firstname'=>'Olivier','lastname'=>'Boudon'],
            ['firstname'=>'Anne Marie','lastname'=>'Loop'],
            ['firstname'=>'Pietro','lastname'=>'Varasso'],
            ['firstname'=>'Laurent','lastname'=>'Caron'],
            ['firstname'=>'Élena','lastname'=>'Perez'],
            ['firstname'=>'Guillaume','lastname'=>'Alexandre'],
            ['firstname'=>'Claude','lastname'=>'Semal'],
            ['firstname'=>'Laurence','lastname'=>'Warin'],
            ['firstname'=>'Pierre','lastname'=>'Wayburn'],
            ['firstname'=>'Gwendoline','lastname'=>'Gauthier'],
        ];
        
        foreach ($artists as $record) {
            $artist = new Artist();
            $artist->setFirstname($record['firstname']);
            $artist->setLastname($record['lastname']);
            $manager->persist($artist);
            $this->addReference(
                $record['firstname']."-".$record['lastname'],
                $artist );
        }


        $manager->flush();
    }
}
