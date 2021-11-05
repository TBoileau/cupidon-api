<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Designer;
use App\Entity\GraphicStyle;
use App\Entity\Level;
use Doctrine\ORM\EntityRepository;

final class DesignerTest extends ApiTestCase
{
    use AuthenticatedClientTrait;

    public function testIfProfileIsUpdated(): void
    {
        $client = static::createAuthenticatedClient('designer+1@email.com');

        $client->request('POST', '/api/designers/profile', ['json' => [
            'email' => 'designer+2@email.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
            'description' => 'Small description',
            'linkedIn' => 'https://www.linkedin.com',
            'twitter' => 'https://www.twitter.com',
            'level' => $this->findIriBy(Level::class, ['id' => 1]),
            'graphicStyle' => $this->findIriBy(GraphicStyle::class, ['id' => 1]),
        ]]);

        $this->assertResponseStatusCodeSame(204);

        /** @var EntityRepository $designerRepository */
        $designerRepository = $client->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository(Designer::class);

        $this->assertNotNull($designerRepository->findOneBy(['email' => 'designer+2@email.com']));
    }
}
