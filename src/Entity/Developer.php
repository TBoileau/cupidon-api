<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\Entity;

#[ApiResource(
    collectionOperations: [
        'post' => [
            'security' => "is_granted('PUBLIC_ACCESS')",
            'output' => false,
        ],
    ],
    itemOperations: [],
)]
#[Entity]
class Developer extends User
{
}
