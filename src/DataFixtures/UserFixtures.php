<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Designer;
use App\Entity\Developer;
use App\Entity\GraphicStyle;
use App\Entity\Level;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $manager->persist($this->createDeveloper());
        $manager->persist($this->createDesigner());
        $manager->flush();
    }

    private function createDeveloper(): Developer
    {
        $developer = new Developer();
        $developer->setFirstName('John');
        $developer->setLastName('Doe');
        $developer->setEmail('developer+1@email.com');
        $developer->setPassword($this->userPasswordHasher->hashPassword($developer, 'password'));

        /** @var Level $level */
        $level = $this->getReference('junior');
        $developer->setLevel($level);

        /** @var GraphicStyle $graphicStyle */
        $graphicStyle = $this->getReference('flat');
        $developer->setGraphicStyle($graphicStyle);

        return $developer;
    }

    private function createDesigner(): Designer
    {
        $designer = new Designer();
        $designer->setFirstName('Jane');
        $designer->setLastName('Doe');
        $designer->setEmail('designer+1@email.com');
        $designer->setPassword($this->userPasswordHasher->hashPassword($designer, 'password'));

        /** @var Level $level */
        $level = $this->getReference('confirmed');
        $designer->setLevel($level);

        /** @var GraphicStyle $graphicStyle */
        $graphicStyle = $this->getReference('retro');
        $designer->setGraphicStyle($graphicStyle);

        return $designer;
    }
}
