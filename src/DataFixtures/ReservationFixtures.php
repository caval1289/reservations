<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Reservation;
use App\DataFixtures\RepresentationFixtures;
use App\DataFixtures\UserFixtures;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $reservations = [
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


        foreach ($reservations as $record) {
            $reservation = new Reservation();
            // Assign the corresponding representation reference
            $reservation->setRepresentation($this->getReference($record['representation']));            
            // Assign the corresponding user reference
            $reservation->setUser($this->getReference($record['user']));
            $reservation->setPlaces($record['places']);
            $manager->persist($reservation);

           
           
            
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
