<?php

namespace App\DataFixtures;

use App\Entity\Quai;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class QuaiFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $count= 100;
        for ($i=0; $i < 11 ; $i++) {
            $count++;
            $quai = new Quai();
            $quai
                ->setNumero($count)
                ;
                $manager->persist($quai);
        }
        $count= 112;
        for ($i=0; $i < 9 ; $i++) {
            $count++;
            $quai = new Quai();
            $quai
                ->setNumero($count)
                ;
                $manager->persist($quai);
        }

        $count= 122;
        for ($i=0; $i < 8 ; $i++) {
            $count++;
            $quai = new Quai();
            $quai
                ->setNumero($count)
                ;
                $manager->persist($quai);
        }

        $count= 138;
        for ($i=0; $i < 4 ; $i++) {
            $count++;
            $quai = new Quai();
            $quai
                ->setNumero($count)
                ;
                $manager->persist($quai);
        }

        $count= 143;
        for ($i=0; $i < 11 ; $i++) {
            $count++;
            $quai = new Quai();
            $quai
                ->setNumero($count)
                ;
                $manager->persist($quai);
        }

        $count= 200;
        for ($i=0; $i < 11 ; $i++) {
            $count++;
            $quai = new Quai();
            $quai
                ->setNumero($count)
                ;
                $manager->persist($quai);
        }

        $count= 212;
        for ($i=0; $i < 8 ; $i++) {
            $count++;
            $quai = new Quai();
            $quai
                ->setNumero($count)
                ;
                $manager->persist($quai);
        }

        $count= 221;
        for ($i=0; $i < 9 ; $i++) {
            $count++;
            $quai = new Quai();
            $quai
                ->setNumero($count)
                ;
                $manager->persist($quai);
        }

        $count= 231;
        for ($i=0; $i < 11 ; $i++) {
            $count++;
            $quai = new Quai();
            $quai
                ->setNumero($count)
                ;
                $manager->persist($quai);
        }

        $count= 243;
        for ($i=0; $i < 11 ; $i++) {
            $count++;
            $quai = new Quai();
            $quai
                ->setNumero($count)
                ;
                $manager->persist($quai);
        }

        $manager->flush();
    }
}
