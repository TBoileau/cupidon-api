<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
)]
#[Entity]
#[Table(name: '`level`')]
class Level
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    protected ?int $id = null;

    #[Column]
    protected string $name;

    #[Column(type: 'text')]
    protected string $description;

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
