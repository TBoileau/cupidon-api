<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Controller\Admin\GraphicStyleCrudController;
use App\Entity\Administrator;
use App\Entity\GraphicStyle;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class GraphicStyleTest extends WebTestCase
{
    public function testIfGraphicStylesAreListed(): void
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
                ->setController(GraphicStyleCrudController::class)
                ->setAction(Action::INDEX)
                ->generateUrl()
        );

        $this->assertResponseIsSuccessful();

        $this->assertCount(2, $crawler->filter('article.content table tbody tr'));
    }

    public function testIfGraphicStyleIsShown(): void
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
                ->setController(GraphicStyleCrudController::class)
                ->setAction(Action::DETAIL)
                ->setEntityId(1)
                ->generateUrl()
        );

        $this->assertResponseIsSuccessful();

        $this->assertStringContainsString('1', $crawler->filter('dl.datalist div:first-child dd')->text());
        $this->assertStringContainsString('Retro', $crawler->filter('dl.datalist div:nth-child(2) dd')->text());
    }

    public function testIfGraphicStyleIsUpdated(): void
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
                ->setController(GraphicStyleCrudController::class)
                ->setAction(Action::EDIT)
                ->setEntityId(1)
                ->generateUrl()
        );

        $client->submitForm('Sauvegarder les modifications', [
            'GraphicStyle[name]' => 'Modifi??',
            'GraphicStyle[file][file]' => new UploadedFile(
                __DIR__.'/../../../public/uploads/graphic_styles/image.png',
                'image.png',
                'image/png',
                null,
                true
            ),
        ]);

        $this->assertResponseRedirects();

        $client->followRedirect();

        $graphicStyle = $entityManager->find(GraphicStyle::class, 1);

        $this->assertEquals('Modifi??', $graphicStyle->getName());
    }

    public function testIfGraphicStyleIsCreated(): void
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
                ->setController(GraphicStyleCrudController::class)
                ->setAction(Action::NEW)
                ->generateUrl()
        );

        $client->submitForm('Cr??er', [
            'GraphicStyle[name]' => 'Nouveau',
            'GraphicStyle[file][file]' => new UploadedFile(
                __DIR__.'/../../../public/uploads/graphic_styles/image.png',
                'image.png',
                'image/png',
                null,
                true
            ),
        ]);

        $this->assertResponseRedirects();

        $client->followRedirect();

        $graphicStyle = $entityManager->getRepository(GraphicStyle::class)->findBy([], ['id' => 'desc'])[0];

        $this->assertEquals('Nouveau', $graphicStyle->getName());
    }

    public function testIfGraphicStyleIsDeleted(): void
    {
        $client = static::createClient();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $graphicStyle = new GraphicStyle();
        $graphicStyle->setName('Nouveau');
        $entityManager->persist($graphicStyle);
        $entityManager->flush();

        /** @var AdminUrlGenerator $adminUrlGenerator */
        $adminUrlGenerator = $client->getContainer()->get(AdminUrlGenerator::class);

        $client->loginUser($entityManager->find(Administrator::class, 1), 'admin');

        $crawler = $client->request(
            'GET',
            $adminUrlGenerator
                ->setController(GraphicStyleCrudController::class)
                ->setAction(Action::DETAIL)
                ->setEntityId($graphicStyle->getId())
                ->generateUrl()
        );

        $client->request(
            'POST',
            $adminUrlGenerator
                ->setController(GraphicStyleCrudController::class)
                ->setAction(Action::DELETE)
                ->setEntityId($graphicStyle->getId())
                ->generateUrl(),
            ['token' => $crawler->filter('form#delete-form input')->attr('value')]
        );

        $this->assertResponseRedirects();

        $client->followRedirect();

        $this->assertNull($entityManager->find(GraphicStyle::class, $graphicStyle->getId()));
    }
}
