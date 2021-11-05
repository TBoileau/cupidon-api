<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Developer;
use App\Entity\GraphicStyle;
use App\Entity\Level;
use Doctrine\ORM\EntityRepository;

final class DeveloperTest extends ApiTestCase
{
    use AuthenticatedClientTrait;

    public function testIfProfileIsUpdated(): void
    {
        $client = static::createAuthenticatedClient('developer+1@email.com');

        $client->request('POST', '/api/developers/profile', ['json' => [
            'email' => 'developer+2@email.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
            'level' => $this->findIriBy(Level::class, ['id' => 1]),
            'graphicStyle' => $this->findIriBy(GraphicStyle::class, ['id' => 1]),
        ]]);

        $this->assertResponseStatusCodeSame(204);

        /** @var EntityRepository $developerRepository */
        $developerRepository = $client->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository(Developer::class);

        $this->assertNotNull($developerRepository->findOneBy(['email' => 'developer+2@email.com']));
    }
}
