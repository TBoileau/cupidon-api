<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Controller\Admin\LevelCrudController;
use App\Entity\Administrator;
use App\Entity\Level;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LevelTest extends WebTestCase
{
    public function testIfLevelsAreListed(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        /** @var AdminUrlGenerator $adminUrlGenerator */
        $adminUrlGenerator = $client->getContainer()->get(AdminUrlGenerator::class);

        $client->loginUser($entityManager->find(Administrator::class, 1), 'admin');

        $crawler = $client->request(
            'GET',
            $adminUrlGenerator
                ->setController(LevelCrudController::class)
                ->setAction(Action::INDEX)
                ->generateUrl()
        );

        $this->assertResponseIsSuccessful();

        $this->assertCount(3, $crawler->filter('article.content table tbody tr'));
    }

    public function testIfLevelIsShown(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        /** @var AdminUrlGenerator $adminUrlGenerator */
        $adminUrlGenerator = $client->getContainer()->get(AdminUrlGenerator::class);

        $client->loginUser($entityManager->find(Administrator::class, 1), 'admin');

        $crawler = $client->request(
            'GET',
            $adminUrlGenerator
                ->setController(LevelCrudController::class)
                ->setAction(Action::DETAIL)
                ->setEntityId(1)
                ->generateUrl()
        );

        $this->assertResponseIsSuccessful();

        $this->assertStringContainsString('1', $crawler->filter('dl.datalist div:first-child dd')->text());
        $this->assertStringContainsString('Junior', $crawler->filter('dl.datalist div:nth-child(2) dd')->text());
        $this->assertStringContainsString('-2 ans d\'expérience', $crawler->filter('dl.datalist div:nth-child(3) dd')->text());
    }

    public function testIfLevelIsUpdated(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        /** @var AdminUrlGenerator $adminUrlGenerator */
        $adminUrlGenerator = $client->getContainer()->get(AdminUrlGenerator::class);

        $client->loginUser($entityManager->find(Administrator::class, 1), 'admin');

        $client->request(
            'GET',
            $adminUrlGenerator
                ->setController(LevelCrudController::class)
                ->setAction(Action::EDIT)
                ->setEntityId(1)
                ->generateUrl()
        );

        $client->submitForm('Sauvegarder les modifications', [
            'Level[description]' => '-1 ans d\'expérience',
            'Level[name]' => 'Mega junior',
        ]);

        $this->assertResponseRedirects();

        $client->followRedirect();

        $level = $entityManager->find(Level::class, 1);

        $this->assertEquals('-1 ans d\'expérience', $level->getDescription());
        $this->assertEquals('Mega junior', $level->getName());
    }

    public function testIfLevelIsCreated(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        /** @var AdminUrlGenerator $adminUrlGenerator */
        $adminUrlGenerator = $client->getContainer()->get(AdminUrlGenerator::class);

        $client->loginUser($entityManager->find(Administrator::class, 1), 'admin');

        $client->request(
            'GET',
            $adminUrlGenerator
                ->setController(LevelCrudController::class)
                ->setAction(Action::NEW)
                ->generateUrl()
        );

        $client->submitForm('Créer', [
            'Level[description]' => '+10 ans d\'expérience',
            'Level[name]' => 'Expert',
        ]);

        $this->assertResponseRedirects();

        $client->followRedirect();

        $level = $entityManager->getRepository(Level::class)->findBy([], ['id' => 'desc'])[0];

        $this->assertEquals('Expert', $level->getName());
    }

    public function testIfLevelIsDeleted(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $level = new Level();
        $level->setName('Expert');
        $level->setDescription('+10 d\'expérience');
        $entityManager->persist($level);
        $entityManager->flush();

        /** @var AdminUrlGenerator $adminUrlGenerator */
        $adminUrlGenerator = $client->getContainer()->get(AdminUrlGenerator::class);

        $client->loginUser($entityManager->find(Administrator::class, 1), 'admin');

        $crawler = $client->request(
            'GET',
            $adminUrlGenerator
                ->setController(LevelCrudController::class)
                ->setAction(Action::DETAIL)
                ->setEntityId($level->getId())
                ->generateUrl()
        );

        $client->request(
            'POST',
            $adminUrlGenerator
                ->setController(LevelCrudController::class)
                ->setAction(Action::DELETE)
                ->setEntityId($level->getId())
                ->generateUrl(),
            ['token' => $crawler->filter('form#delete-form input')->attr('value')]
        );

        $this->assertResponseRedirects();

        $client->followRedirect();

        $this->assertNull($entityManager->find(Level::class, $level->getId()));
    }
}
