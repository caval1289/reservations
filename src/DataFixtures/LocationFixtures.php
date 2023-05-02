<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Location;
use Cocur\Slugify\Slugify;



class LocationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $locations = [
            [
                'slug'=>null,
                'designation'=>'Espace Delvaux / La Vénerie',
                'address'=>'3 rue Gratès',
                'locality'=>'Watermael-Boitsfort',
                'website'=>'https://www.lavenerie.be',
                'phone'=>'+32 (0)2/663.85.50',
            ],
            [
                'slug'=>null,
                'designation'=>'Dexia Art Center',
                'address'=>'50 rue de l\'Ecuyer',
                'locality' =>'Bruxelles',
                'website'=>null,
                'phone'=>null,
            ],
            [
                'slug'=>null,
                'designation'=>'La Samaritaine',
                'address'=>'16 rue de la samaritaine',
                'locality'=>'Bruxelles',
                'website'=>'http://www.lasamaritaine.be/',
                'phone'=>null,
            ],
            [
                'slug'=>null,
                'designation'=>'Espace Magh',
                'address'=>'17 rue du Poinçon',
                'locality'=>'Bruxelles',
                'website'=>'http://www.espacemagh.be',
                'phone'=>'+32 (0)2/274.05.10',
            ],
        ];
        foreach ($locations as $record) {
            $slugify = new Slugify();
            $location_slug = $slugify->slugify($record['designation']);
            $location = new Location();
            $location->setSlug($location_slug);
            $location->setDesignation($record['designation']);
            $location->setAdress($record['address']);
            $location->setLocality($this->getReference($record['locality']));
            $location->setWebsite($record['website']);
            $location->setPhone($record['phone']);
            $manager->persist($location); 
            $this->addReference($location->getSlug(), $location);
            }
    

        
        $manager->flush();
        
        
    }

    public function getDependencies() {
        return [
            LocalityFixtures::class,
        ];
    }
    

}
