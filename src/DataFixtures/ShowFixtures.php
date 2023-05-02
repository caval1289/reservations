<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Show;
use Cocur\Slugify\Slugify;
use App\DataFixtures\Location;
use App\Repository\LocationRepository;


class ShowFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $shows = [
            [
                'slug'=>null,
                'title'=>'Ayiti',
                'description'=>"Un homme est bloqué à l’aéroport.\n "
                    . 'Questionné par les douaniers, il doit alors justifier son identité, '
                    . 'et surtout prouver qu\'il est haïtien – qu\'est-ce qu\'être haïtien ?',
                'poster_url'=>'ayiti.jpg',
                'location_slug'=>'espace-delvaux-la-venerie',
                'bookable'=>true,
                'price'=>8.50,
            ],
           [
                'slug'=>null,
                'title'=>'Cible mouvante',
                'description'=>'Dans ce « thriller d’anticipation », des adultes semblent alimenter '
                    . 'et véhiculer une crainte féroce envers les enfants âgés entre 10 et 12 ans.',
                'poster_url'=>'cible.jpg',
                'location_slug'=>'dexia-art-center',
                'bookable'=>true,
                'price'=>9.00,
            ],
            [
                'slug'=>null,
                'title'=>'Ceci n\'est pas un chanteur belge',
                'description'=>"Non peut-être ?!\nEntre Magritte (pour le surréalisme comique) "
                    . 'et Maigret (pour le réalisme mélancolique), ce dixième opus semalien propose '
                    . 'quatorze nouvelles chansons mêlées à de petits textes humoristiques et '
                    . 'à quelques fortes images poétiques.',
                'poster_url'=>'claudebelgesaison220.jpg',
                'location_slug'=>'dexia-art-center',
                'bookable'=>false,
                'price'=>5.50,
            ],
            [
                'slug'=>null,
                'title'=>'Manneke… !',
                'description'=>'A tour de rôle, Pierre se joue de ses oncles, '
                    . 'tantes, grands-parents et surtout de sa mère.',
                'poster_url'=>'wayburn.jpg',
                'location_slug'=>'la-samaritaine',
                'bookable'=>true,
                'price'=>10.50,
            ],
        ];

        foreach ($shows as $record) {
            $slugify = new Slugify();
            
            $show = new Show();            
            $show->setSlug($slugify->slugify($record['title']));
            $show->setTitle($record['title']);
            $show->setDescription($record['description']);
            $show->setPosterUrl($record['poster_url']);
            //var_dump($record['location_slug']);
            //Vérifier avec le prof
            if($record['location_slug']) {
                $show->setLocation($this->getReference($record['location_slug']));
            }                   

            $show->setBookable($record['bookable']);
            $show->setPrice($record['price']);
            $this->addReference($show->getSlug(), $show);            
            
            $manager->persist($show);
        }


        $manager->flush();
        
        
    }

    public function getDependencies() {
        return [
            LocationFixtures::class,
        ];
    }
}
