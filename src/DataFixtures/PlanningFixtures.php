<?php

namespace App\DataFixtures;

use App\Entity\Planning;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PlanningFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $trac1 = new Planning();
        $trac1->setTournee('300');
        $trac1->setChauffeur('Frédéric Kuik');
        $trac1->setTracteur('1TDZ439');
        $manager->persist($trac1);

        $trac2 = new Planning();
        $trac2->setTournee('301');
        $trac2->setChauffeur('Christian Albrecht');
        $trac2->setTracteur('1NAL270');
        $manager->persist($trac2);

        $trac3 = new Planning();
        $trac3->setTournee('302');
        $trac3->setChauffeur('Mickaël Daully');
        $trac3->setTracteur('1TDZ439');
        $manager->persist($trac3);

        $manager->flush();
    }
}
