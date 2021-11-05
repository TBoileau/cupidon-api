<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Api\Designer\UpdateProfile;
use Doctrine\ORM\Mapping\Entity;

#[ApiResource(
    collectionOperations: [
        'post' => [
            'security' => "is_granted('PUBLIC_ACCESS')",
            'output' => false,
        ],
        'profile' => [
            'method' => 'POST',
            'path' => '/designers/profile',
            'controller' => UpdateProfile::class,
            'denormalization_context' => ['groups' => 'profile'],
            'security' => "is_granted('ROLE_DESIGNER')",
            'output' => false,
        ],
    ],
    itemOperations: [],
)]
#[Entity]
class Designer extends User
{
    /**
     * @return array<array-key, string>
     */
    public function getRoles(): array
    {
        return array_merge(parent::getRoles(), ['ROLE_DESIGNER']);
    }
}
