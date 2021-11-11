<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Stringable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable()
 */
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
)]
#[Entity]
class GraphicStyle implements Stringable
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private ?int $id = null;

    #[Column]
    #[NotBlank]
    private string $name;

    #[Column(nullable: true)]
    private ?string $filename = null;

    /**
     * @Vich\UploadableField(mapping="graphic_style", fileNameProperty="filename")
     */
    private ?File $file = null;

    #[Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->updatedAt = new DateTimeImmutable();
    }

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

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): void
    {
        $this->file = $file;
        $this->updatedAt = new DateTimeImmutable();
    }
}
