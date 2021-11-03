<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Controller\Admin\GraphicStyleCrudController;
use App\Entity\Administrator;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
}
