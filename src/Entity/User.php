<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Url;

#[Entity]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'discr', type: 'string')]
#[DiscriminatorMap(['designer' => Designer::class, 'developer' => Developer::class])]
#[Table(name: '`user`')]
#[UniqueEntity(fields: 'email', entityClass: User::class, repositoryMethod: 'findByEmail')]
abstract class User extends BaseUser
{
    #[ManyToOne(targetEntity: Level::class)]
    #[JoinColumn(nullable: false)]
    #[ApiProperty(readableLink: false, writableLink: false)]
    #[NotNull]
    #[Groups(['profile', 'register'])]
    protected Level $level;

    #[ManyToOne(targetEntity: GraphicStyle::class)]
    #[JoinColumn(nullable: false)]
    #[ApiProperty(readableLink: false, writableLink: false)]
    #[NotNull]
    #[Groups(['profile', 'register'])]
    protected GraphicStyle $graphicStyle;

    #[Column(type: 'text')]
    #[NotBlank]
    #[Groups(['profile', 'register'])]
    protected string $description;

    #[Column(nullable: true)]
    #[Url]
    #[Groups(['profile', 'register'])]
    protected ?string $linkedIn = null;

    #[Column(nullable: true)]
    #[Url]
    #[Groups(['profile', 'register'])]
    protected ?string $twitter = null;

    public function getLevel(): Level
    {
        return $this->level;
    }

    public function setLevel(Level $level): void
    {
        $this->level = $level;
    }

    public function getGraphicStyle(): GraphicStyle
    {
        return $this->graphicStyle;
    }

    public function setGraphicStyle(GraphicStyle $graphicStyle): void
    {
        $this->graphicStyle = $graphicStyle;
    }

    /**
     * @return array<array-key, string>
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getLinkedIn(): ?string
    {
        return $this->linkedIn;
    }

    public function setLinkedIn(?string $linkedIn): void
    {
        $this->linkedIn = $linkedIn;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): void
    {
        $this->twitter = $twitter;
    }
}
