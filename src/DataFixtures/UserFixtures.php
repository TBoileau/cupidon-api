<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Designer;
use App\Entity\Developer;
use App\Entity\User;
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
        $developer = new Developer();
        $developer->setEmail('developer+1@email.com');
        $developer->setPassword($this->userPasswordHasher->hashPassword($developer, 'password'));
        $manager->persist($developer);

        $designer = new Designer();
        $designer->setEmail('designer+1@email.com');
        $designer->setPassword($this->userPasswordHasher->hashPassword($designer, 'password'));
        $manager->persist($designer);
        $manager->flush();
    }
}
