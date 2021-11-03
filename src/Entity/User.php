<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[Entity]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'discr', type: 'string')]
#[DiscriminatorMap(['designer' => Designer::class, 'developer' => Developer::class])]
#[Table(name: '`user`')]
#[UniqueEntity(fields: 'email')]
abstract class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    protected ?int $id = null;

    #[Column(unique: true)]
    protected string $email;

    #[Column]
    protected string $password;

    #[Column]
    protected string $firstName;

    #[Column]
    protected string $lastName;

    #[ManyToOne(targetEntity: Level::class)]
    #[JoinColumn(nullable: false)]
    #[ApiProperty(readableLink: false, writableLink: false)]
    protected Level $level;

    #[ManyToOne(targetEntity: GraphicStyle::class)]
    #[JoinColumn(nullable: false)]
    #[ApiProperty(readableLink: false, writableLink: false)]
    protected GraphicStyle $graphicStyle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

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

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUsername(): string
    {
        return $this->email;
    }
}
