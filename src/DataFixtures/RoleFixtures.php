<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Role;

class RoleFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $roles = [
            ['role'=>'admin'],
            ['role'=>'membre'],
           
        ];

        foreach ($roles as $record) {
            $role = new Role();
            $role->setRole($record['role']);            
            $manager->persist($role);
            $this->addReference($record['role'], $role);
        }


        $manager->flush();
    }
}
