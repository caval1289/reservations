<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\RepresentationFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\RepresentationUser;

class RepresentationUserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $representation_user= [
            [
                'representation'=>'ayiti-201810121330',
                'user'=>'bob',
                'places'=>2,
            ],
            [
                'representation'=>'cible-mouvante-201810122030',
                'user'=>'bob',
                'places'=>1,
            ],
            [
                'representation'=>'ayiti-201810121330',
                'user'=>'fred',
                'places'=>1,
            ],           
        ];


        foreach ($representation_user as $record) {
            $representation_user = new RepresentationUser();
            // Assign the corresponding representation reference
            $representation_user->setRepresentation($this->getReference($record['representation']));            
            // Assign the corresponding user reference
            $representation_user->setUser($this->getReference($record['user']));
            $representation_user->setPlaces($record['places']);
            $manager->persist($representation_user);

           
           
            
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            RepresentationFixtures::class,
        ];
    }
}
