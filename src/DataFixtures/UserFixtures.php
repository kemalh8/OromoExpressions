<?php

namespace App\DataFixtures;
use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername("user");
        $user->setEmail("user@gmail.com"); 
        $user->setPassword($this->hasher->hashPassword($user, "user"));
        $user->setCountry("Oromia");
        $user->setCity("Finfine");
        $user->setNumber("0922060394");
        $user->setRoles(["ROLE_USER"]);


        $admin = new User();
        $admin->setUsername("admin");
        $admin->setEmail("admin@gmail.com"); 
        $admin->setPassword($this->hasher->hashPassword($admin, "admin"));
        $admin->setCountry("France");
        $admin->setCity("Lyon");
        $admin->setNumber("0672581121");
        $admin->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user);
        $manager->persist($admin);
        $manager->flush();
    }
}
