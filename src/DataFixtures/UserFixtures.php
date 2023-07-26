<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct (UserPasswordHasherInterface $hasher){
        $this->hasher=$hasher;
    }
    public function load(ObjectManager $manager): void
    {
//        $testUser = new User();
//        $testUser -> setLastName("user");
//        $testUser -> setFirstName("user");
//        $testUser -> setEmail("user@mail");
//        //        pour rendre la fixture opé même sans la validation par mail
////        ne fonctionne pas car dfu impossible du fait de contrainte
////        de clé étangère
//        $testUser->setIsVerified(true);
//        $encodedPassword = $this->hasher->hashPassword($testUser, "user");
//        $testUser -> setPassword("$encodedPassword");

        $testAdmin = new User();
        $testAdmin -> setLastName("admin");
        $testAdmin -> setFirstName("admin");
        $testAdmin -> setEmail("admin@mail");
        $encodedPassword = $this->hasher->hashPassword($testAdmin, "admin");
        $testAdmin -> setPassword("$encodedPassword");
        $testAdmin->setRoles(["ROLE_ADMIN"]);
//        pour rendre la fixture opé même sans la validation par mail
//        ne fonctionne pas car dfu impossible du fait de contrainte
//        de clé étangère
        $testAdmin->setIsVerified(true);

//        $manager->persist($testUser);
        $manager->persist($testAdmin);

        $manager->flush();
    }
}
