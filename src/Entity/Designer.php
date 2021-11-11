<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Api\Designer\UpdateProfile;
use App\Controller\Api\UploadAvatar;
use Doctrine\ORM\Mapping\Entity;

#[ApiResource(
    collectionOperations: [
        'post' => [
            'security' => "is_granted('PUBLIC_ACCESS')",
            'denormalization_context' => ['groups' => 'register'],
            'validation_groups' => ['Default', 'register'],
            'output' => false,
        ],
        'avatar' => [
            'method' => 'POST',
            'security' => "is_granted('ROLE_DESIGNER')",
            'path' => '/designers/avatar',
            'denormalization_context' => ['groups' => 'avatar'],
            'validation_groups' => ['Default', 'avatar'],
            'output' => false,
            'controller' => UploadAvatar::class,
            'deserialize' => false,
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
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
