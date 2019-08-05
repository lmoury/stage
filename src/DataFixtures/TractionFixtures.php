<?php

namespace App\DataFixtures;

use App\Entity\Traction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TractionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $trac1 = new Traction();
        $trac1->setAffectation('Dartford');
        $trac1->setPorte('102');
        $manager->persist($trac1);

        $trac2 = new Traction();
        $trac2->setAffectation('Koblenz Mannheim');
        $trac2->setPorte('105');
        $manager->persist($trac2);

        $trac3 = new Traction();
        $trac3->setAffectation('Hamburg');
        $trac3->setPorte('108');
        $manager->persist($trac3);

        $trac4 = new Traction();
        $trac4->setAffectation('Bremen');
        $trac4->setPorte('109');
        $manager->persist($trac4);

        $trac5 = new Traction();
        $trac5->setAffectation('Alsdorf Cologne');
        $trac5->setPorte('111');
        $manager->persist($trac5);

        $manager->flush();
    }
}
