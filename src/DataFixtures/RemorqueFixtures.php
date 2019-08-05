<?php

namespace App\DataFixtures;

use App\Entity\Remorque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class RemorqueFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $count= 1;
        // for ($i=0; $i < 5 ; $i++) {
        //     $count++;
        //     $quai = new Remorque();
        //     $quai
        //         ->setRemorque('SA62'.$count)
        //         ->setImmatriculation('1-QCL-8'.$count)
        //         ->setType($manager->merge($this->getReference('type1')))
        //         ;
        //         $manager->persist($quai);
        // }
        //
        // $count= 6;
        // for ($i=0; $i < 5 ; $i++) {
        //     $count++;
        //     $quai = new Remorque();
        //     $quai
        //         ->setRemorque('SA62'.$count)
        //         ->setImmatriculation('1-QCL-8'.$count)
        //         ->setType($manager->merge($this->getReference('type2')))
        //         ;
        //         $manager->persist($quai);
        // }
        //
        // $count= 11;
        // for ($i=0; $i < 5 ; $i++) {
        //     $count++;
        //     $quai = new Remorque();
        //     $quai
        //         ->setRemorque('SA62'.$count)
        //         ->setImmatriculation('1-QCL-8'.$count)
        //         ->setType($manager->merge($this->getReference('type3')))
        //         ;
        //         $manager->persist($quai);
        // }
        //
        // $manager->flush();
    }

    public function getOrder() {
        return 2;
    }
}
