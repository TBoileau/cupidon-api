<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\GraphicStyle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function Symfony\Component\String\u;

final class GraphicStyleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist($this->createGraphicStyle('Flat'));
        $manager->persist($this->createGraphicStyle('Retro'));

        $manager->flush();
    }

    private function createGraphicStyle(string $name): GraphicStyle
    {
        $slug = u($name)->lower()->toString();
        copy(
            __DIR__.'/../../public/uploads/graphic_styles/image.png',
            sprintf(__DIR__.'/../../public/uploads/graphic_styles/%s.png', $slug)
        );
        $graphicStyle = new GraphicStyle();
        $graphicStyle->setName('Retro');
        $graphicStyle->setFilename(sprintf('%s.png', $slug));
        $this->addReference($slug, $graphicStyle);

        return $graphicStyle;
    }
}
