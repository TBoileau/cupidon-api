<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Api\Developer\UpdateProfile;
use Doctrine\ORM\Mapping\Entity;

#[ApiResource(
    collectionOperations: [
        'post' => [
            'security' => "is_granted('PUBLIC_ACCESS')",
            'denormalization_context' => ['groups' => 'register'],
            'validation_groups' => ['Default', 'register'],
            'output' => false,
        ],
        'profile' => [
            'method' => 'POST',
            'path' => '/developers/profile',
            'controller' => UpdateProfile::class,
            'denormalization_context' => ['groups' => 'profile'],
            'security' => "is_granted('ROLE_DEVELOPER')",
            'output' => false,
        ],
    ],
    itemOperations: [],
)]
#[Entity]
class Developer extends User
{
    /**
     * @return array<array-key, string>
     */
    public function getRoles(): array
    {
        return array_merge(parent::getRoles(), ['ROLE_DEVELOPER']);
    }
}
