<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
$users = []; 

$admin = new User(); 
$admin

->setEmail('admin@admin.com')
->setRoles(["ROLE_USER"])
->setPassword('123')
->setLogin('sams')
->setFirstname('samir')
->setLastname('Boudekhan')
->setLanguage('fr');


$users[]= $admin;

$manager -> persist($admin);

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
