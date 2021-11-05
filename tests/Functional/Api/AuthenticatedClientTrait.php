<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;

trait AuthenticatedClientTrait
{
    public static function createAuthenticatedClient(string $email): Client
    {
        $token = static::createClient()->request('POST', '/api/login_check', ['json' => [
            'email' => $email,
            'password' => 'password',
        ]])->toArray()['token'];

        return static::createClient([], [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $token),
            ],
        ]);
    }
}
