<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Stringable;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
)]
#[Entity]
#[Table(name: '`level`')]
class Level implements Stringable
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private ?int $id = null;

    #[Column]
    private string $name;

    #[Column(type: 'text')]
    private string $description;

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
