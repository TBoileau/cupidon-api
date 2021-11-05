<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
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

        $this->assertResponseStatusCodeSame(204);
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

        $this->assertResponseStatusCodeSame(204);
    }
}
