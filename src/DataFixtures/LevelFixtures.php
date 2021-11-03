<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Level;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class LevelFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $junior = new Level();
        $junior->setName('Junior');
        $junior->setDescription('-2 ans d\'expérience');
        $manager->persist($junior);
        $this->addReference('junior', $junior);

        $confirmed = new Level();
        $confirmed->setName('Confirmé');
        $confirmed->setDescription('Entre 2 et 5 ans d\'expérience');
        $manager->persist($confirmed);
        $this->addReference('confirmed', $confirmed);

        $senior = new Level();
        $senior->setName('Senior');
        $senior->setDescription('+5 ans d\'expérience');
        $manager->persist($senior);
        $this->addReference('senior', $senior);

        $manager->flush();
    }
}
