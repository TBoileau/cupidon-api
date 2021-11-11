<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Developer;
use App\Entity\GraphicStyle;
use App\Entity\Level;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class DeveloperTest extends ApiTestCase
{
    use AuthenticatedClientTrait;

    public function testIfProfileIsUpdated(): void
    {
        $client = static::createAuthenticatedClient('developer+1@email.com');

        $client->request('POST', '/api/developers/profile', [
            'json' => [
                'email' => 'developer+2@email.com',
                'firstName' => 'John',
                'lastName' => 'Doe',
                'description' => 'Small description',
                'linkedIn' => 'https://www.linkedin.com',
                'twitter' => 'https://www.twitter.com',
                'level' => $this->findIriBy(Level::class, ['id' => 1]),
                'graphicStyle' => $this->findIriBy(GraphicStyle::class, ['id' => 1]),
            ],
        ]);

        $this->assertResponseStatusCodeSame(204);

        /** @var EntityRepository $developerRepository */
        $developerRepository = $client->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository(Developer::class);

        $this->assertNotNull($developerRepository->findOneBy(['email' => 'developer+2@email.com']));
    }

    public function testIfAvatarIsUpdated(): void
    {
        $client = static::createAuthenticatedClient('developer+1@email.com');

        copy(
            __DIR__.'/../../../public/uploads/avatar/image.png',
            __DIR__.'/../../../public/uploads/avatar/image_test.png'
        );

        $client->request('POST', '/api/developers/avatar', [
            'headers' => ['Content-Type' => 'multipart/form-data'],
            'extra' => [
                'files' => [
                    'file' => new UploadedFile(
                        __DIR__.'/../../../public/uploads/avatar/image_test.png',
                        'image.png',
                        'image/png',
                        null,
                        true
                    ),
                ],
            ],
        ]);

        $this->assertResponseStatusCodeSame(204);
    }
}
