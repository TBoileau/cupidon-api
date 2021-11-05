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
                    'plainPassword' => 'password',
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'description' => 'Small description',
                    'linkedIn' => 'https://www.linkedin.com',
                    'twitter' => 'https://www.twitter.com',
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
                    'plainPassword' => 'password',
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'description' => 'Small description',
                    'linkedIn' => 'https://www.linkedin.com',
                    'twitter' => 'https://www.twitter.com',
                    'level' => $this->findIriBy(Level::class, ['id' => 1]),
                    'graphicStyle' => $this->findIriBy(GraphicStyle::class, ['id' => 1]),
                ],
            ]
        );

        $this->assertResponseStatusCodeSame(204);
    }

    /**
     * @param array{email: string, plainPassword: string, firstName: string, lastName: string, description: string, linkedIn: string, twitter: string, level: string, graphicStyle: string} $data
     * @dataProvider provideBadData
     */
    public function testIfRegistrationFailedWithBadData(array $data): void
    {
        static::createClient()->request(
            'POST',
            '/api/developers',
            [
                'json' => $data,
            ]
        );

        $this->assertResponseStatusCodeSame(400);
    }

    public function provideBadData(): iterable
    {
        $baseData = static fn (array $data): array => $data + [
                'email' => 'email@email.com',
                'plainPassword' => 'password',
                'firstName' => 'John',
                'lastName' => 'Doe',
                'description' => 'Small description',
                'linkedIn' => 'https://www.linkedin.com',
                'twitter' => 'https://www.twitter.com',
                'level' => '/api/levels/1',
                'graphicStyle' => '/api/graphic_styles/1',
            ];

        yield 'level is empty' => [$baseData(['level' => ''])];
        yield 'level is bad iri' => [$baseData(['level' => '/fail'])];
        yield 'level not exists' => [$baseData(['level' => '/api/levels/52'])];
        yield 'graphicStyle is empty' => [$baseData(['graphicStyle' => ''])];
        yield 'graphicStyle is bad iri' => [$baseData(['graphicStyle' => '/fail'])];
        yield 'graphicStyle not exists' => [$baseData(['graphicStyle' => '/api/graphic_styles/52'])];
    }

    /**
     * @param array{email: string, plainPassword: string, firstName: string, lastName: string, description: string, linkedIn: string, twitter: string, level: string, graphicStyle: string} $data
     * @dataProvider provideFailedData
     */
    public function testIfRegistrationFailed(array $data): void
    {
        static::createClient()->request(
            'POST',
            '/api/developers',
            [
                'json' => $data,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
    }

    public function provideFailedData(): iterable
    {
        $baseData = static fn (array $data): array => $data + [
            'email' => 'email@email.com',
            'plainPassword' => 'password',
            'firstName' => 'John',
            'lastName' => 'Doe',
            'description' => 'Small description',
            'linkedIn' => 'https://www.linkedin.com',
            'twitter' => 'https://www.twitter.com',
            'level' => '/api/levels/1',
            'graphicStyle' => '/api/graphic_styles/1',
        ];

        yield 'email is invalid' => [$baseData(['email' => 'fail'])];
        yield 'email is empty' => [$baseData(['email' => ''])];
        yield 'plainPassword is empty' => [$baseData(['plainPassword' => ''])];
        yield 'firstName is empty' => [$baseData(['firstName' => ''])];
        yield 'lastName is empty' => [$baseData(['lastName' => ''])];
        yield 'description is empty' => [$baseData(['description' => ''])];
        yield 'linkedIn is invalid' => [$baseData(['linkedIn' => 'fail'])];
        yield 'twitter is invalid' => [$baseData(['twitter' => 'fail'])];
    }
}
