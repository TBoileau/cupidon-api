<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Controller\Admin\DeveloperCrudController;
use App\Entity\Administrator;
use App\Entity\Developer;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DeveloperTest extends WebTestCase
{
    public function testIfDevelopersAreListed(): void
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
                ->setController(DeveloperCrudController::class)
                ->setAction(Action::INDEX)
                ->generateUrl()
        );

        $this->assertResponseIsSuccessful();

        $this->assertCount(1, $crawler->filter('article.content table tbody tr'));
    }

    public function testIfDeveloperIsShown(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        /** @var AdminUrlGenerator $adminUrlGenerator */
        $adminUrlGenerator = $client->getContainer()->get(AdminUrlGenerator::class);

        /** @var Developer $developer */
        $developer = $entityManager->getRepository(Developer::class)->findOneBy([]);

        $client->loginUser($entityManager->find(Administrator::class, 1), 'admin');

        $client->request(
            'GET',
            $adminUrlGenerator
                ->setController(DeveloperCrudController::class)
                ->setAction(Action::DETAIL)
                ->setEntityId($developer->getId())
                ->generateUrl()
        );

        $this->assertResponseIsSuccessful();
    }

    public function testIfDeveloperIsDeleted(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        /** @var Developer $developer */
        $developer = $entityManager->getRepository(Developer::class)->findOneBy([]);

        /** @var AdminUrlGenerator $adminUrlGenerator */
        $adminUrlGenerator = $client->getContainer()->get(AdminUrlGenerator::class);

        $client->loginUser($entityManager->find(Administrator::class, 1), 'admin');

        $crawler = $client->request(
            'GET',
            $adminUrlGenerator
                ->setController(DeveloperCrudController::class)
                ->setAction(Action::DETAIL)
                ->setEntityId($developer->getId())
                ->generateUrl()
        );

        $client->request(
            'POST',
            $adminUrlGenerator
                ->setController(DeveloperCrudController::class)
                ->setAction(Action::DELETE)
                ->setEntityId($developer->getId())
                ->generateUrl(),
            ['token' => $crawler->filter('form#delete-form input')->attr('value')]
        );

        $this->assertResponseRedirects();

        $client->followRedirect();

        $this->assertNull($entityManager->find(Developer::class, $developer->getId()));
    }
}
