<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\GraphicStyle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class GraphicStyleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $flat = new GraphicStyle();
        $flat->setName('Flat design');
        $manager->persist($flat);
        $this->addReference('flat', $flat);

        $retro = new GraphicStyle();
        $retro->setName('Retro');
        $manager->persist($retro);
        $this->addReference('retro', $retro);

        $manager->flush();
    }
}
