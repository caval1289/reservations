<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Representation;



class RepresentationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $representations = [
            [
                'ref'=>'ayiti-201810121330',
                'show'=>'ayiti',
                'location'=>'espace-delvaux-la-venerie',
                'schedule'=> ('2018-10-12 13:30:00'),
            ],
            [
                'ref'=>'ayiti-201810122030',
                'show'=>'ayiti',
                'location'=>'dexia-art-center',
                'schedule'=>('2018-10-12 20:30:00'),
            ],
            [
                'ref'=>'cible-mouvante-201810122030',
                'show'=>'cible-mouvante',
                'location'=>null,
                'schedule'=>('2018-10-12 20:30:00'),
            ],
            [
                'ref'=>'cible-mouvante-201810142030',
                'show'=>'cible-mouvante',
                'location'=>null,
                'schedule'=>('2018-10-14 20:30:00'),
            ],
            [
                'ref'=>'chanteur-belge-201810142030',
                'show'=>'ceci-n-est-pas-un-chanteur-belge',
                'location'=>null,
                'schedule'=>('2018-10-14 20:30:00'),
            ],             
        ];



        foreach ($representations as $record) {           
            $representation = new Representation();
            
           if($record['location']) {
                $representation->setTheLocation($this->getReference($record['location']));
            }
            
            $representation->setTheShow($this->getReference($record['show']));
            $representation->setSchedule(new \DateTime($record['schedule']));
                        
            $manager->persist($representation);
            $this->addReference($record['ref'], $representation);
        }



        $manager->flush();

        
    }

    public function getDependencies() {
        return [
            LocationFixtures::class,
            ShowFixtures::class,
        ];
    }

}
