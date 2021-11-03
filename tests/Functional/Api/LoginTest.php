<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

final class LoginTest extends ApiTestCase
{
    public function testIfLoginReturnsToken(): void
    {
        $response = static::createClient()->request(
            'GET',
            '/api/login_check',
            [
                'json' => [
                    'email' => 'developer+1@email.com',
                    'password' => 'password',
                ],
            ]
        );

        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $response->toArray());
    }
}
