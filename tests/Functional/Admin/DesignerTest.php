<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Controller\Admin\DesignerCrudController;
use App\Entity\Administrator;
use App\Entity\Designer;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DesignerTest extends WebTestCase
{
    public function testIfDesignersAreListed(): void
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
                ->setController(DesignerCrudController::class)
                ->setAction(Action::INDEX)
                ->generateUrl()
        );

        $this->assertResponseIsSuccessful();

        $this->assertCount(1, $crawler->filter('article.content table tbody tr'));
    }

    public function testIfDesignerIsShown(): void
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
                ->setController(DesignerCrudController::class)
                ->setAction(Action::DETAIL)
                ->setEntityId(1)
                ->generateUrl()
        );

        $this->assertResponseIsSuccessful();
    }

    public function testIfDesignerIsDeleted(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $graphicStyle = $entityManager->getRepository(Designer::class)->findOneBy([]);

        /** @var AdminUrlGenerator $adminUrlGenerator */
        $adminUrlGenerator = $client->getContainer()->get(AdminUrlGenerator::class);

        $client->loginUser($entityManager->find(Administrator::class, 1), 'admin');

        $crawler = $client->request(
            'GET',
            $adminUrlGenerator
                ->setController(DesignerCrudController::class)
                ->setAction(Action::DETAIL)
                ->setEntityId($graphicStyle->getId())
                ->generateUrl()
        );

        $client->request(
            'POST',
            $adminUrlGenerator
                ->setController(DesignerCrudController::class)
                ->setAction(Action::DELETE)
                ->setEntityId($graphicStyle->getId())
                ->generateUrl(),
            ['token' => $crawler->filter('form#delete-form input')->attr('value')]
        );

        $this->assertResponseRedirects();

        $client->followRedirect();

        $this->assertNull($entityManager->find(Designer::class, $graphicStyle->getId()));
    }
}
