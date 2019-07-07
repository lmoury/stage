<?php

namespace App\DataFixtures;

use App\Entity\RemorqueType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class RemorqueTypeFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $type1 = new RemorqueType();
        $type1->setDenomination('Bâché');
        $manager->persist($type1);

        $type2 = new RemorqueType();
        $type2->setDenomination('Double Plancher Hayon');
        $manager->persist($type2);

        $type3 = new RemorqueType();
        $type3->setDenomination('Double Plancher');
        $manager->persist($type3);

        $manager->flush();
        $this->addReference('type1', $type1);
        $this->addReference('type2', $type2);
        $this->addReference('type3', $type3);

    }

    public function getOrder() {
        return 1;
    }
}
