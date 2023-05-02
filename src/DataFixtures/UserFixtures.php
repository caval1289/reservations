<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
                           

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct (UserPasswordHasherInterface $passwordHasher) 
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'login'=>'bob',
                'password'=>'123',
                'role'=>'ROLE_ADMIN',
                'firstname'=>'Bob',
                'lastname'=>'Sull',
                'email'=>'bob@sull.com',
                'langue'=>'fr',
            ],
            [
                'login'=>'fred',
                'password'=>'123',
                'role'=>'ROLE_USER',
                'firstname'=>'Fred',
                'lastname'=>'Sull',
                'email'=>'fred@sull.com',
                'langue'=>'en',
            ],
        ];

        foreach ($users as $record) {
            $user = new User();

            $user->setLogin($record['login']);
            $user->setFirstname($record['firstname']);
            $user->setLastname($record['lastname']);
            $user->setEmail($record['email']);
            $user->setLanguage($record['langue']);
            $user->setRoles([ $record['role'] ]);

            //Hasher le mot de passe (sur base de la config security.yaml pour la classe $user)
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user, $record['password']
            );
            $user->setPassword($hashedPassword);
            $manager->persist($user);
            $this->addReference($record['login'], $user);           

        }

        $manager->flush();
        
    }
}