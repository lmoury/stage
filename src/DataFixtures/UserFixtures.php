<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // for ($i=0; $i < 10 ; $i++) {
        //     $user = new User();
        //     $user
        //         ->setNom('laurent')
        //         ->setPrenom('moury')
        //         ->setRole('ROLE_ADMIN')
        //         ->setDateCreation(new \DateTime())
        //         ->setDateEdition(new \DateTime())
        //         ;
        //         $manager->persist($user);
        //     // $product = new Product();
        //     // $manager->persist($product);
        // }
        // $manager->flush();
    }

    public function getOrder() {
        return 4;
    }
}
