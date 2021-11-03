<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Designer;
use App\Entity\Developer;
use App\Entity\GraphicStyle;
use App\Entity\Level;

final class RegistrationTest extends ApiTestCase
{
    public function testIfDesignerIsRegistered(): void
    {
        static::createClient()->request(
            'POST',
            '/api/designers',
            [
                'json' => [
                    'email' => 'designer+2@email.com',
                    'password' => 'password',
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'level' => $this->findIriBy(Level::class, ['id' => 1]),
                    'graphicStyle' => $this->findIriBy(GraphicStyle::class, ['id' => 1]),
                ],
            ]
        );

        $this->assertResponseIsSuccessful();
        $this->assertMatchesResourceItemJsonSchema(Designer::class);
    }

    public function testIfDeveloperIsRegistered(): void
    {
        static::createClient()->request(
            'POST',
            '/api/developers',
            [
                'json' => [
                    'email' => 'developer+2@email.com',
                    'password' => 'password',
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'level' => $this->findIriBy(Level::class, ['id' => 1]),
                    'graphicStyle' => $this->findIriBy(GraphicStyle::class, ['id' => 1]),
                ],
            ]
        );

        $this->assertResponseIsSuccessful();
        $this->assertMatchesResourceItemJsonSchema(Developer::class);
    }
}
