<?php

namespace App\DataFixtures;

use App\Entity\Remorque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RemorqueFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $count= 1;
        // for ($i=0; $i < 30 ; $i++) {
        //     $count++;
        //     $quai = new Remorque();
        //     $quai
        //         ->setRemorque('SA62'.$count)
        //         ->setImmatriculation('1-QCL-8'.$count)
        //         ->setType(1)
        //         ;
        //         $manager->persist($quai);
        // }

        $manager->flush();
    }
}
