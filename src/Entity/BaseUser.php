<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

abstract class BaseUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    protected ?int $id = null;

    #[Column(type: 'datetime_immutable')]
    protected DateTimeImmutable $registeredAt;

    #[Column(unique: true)]
    #[NotBlank]
    #[Email]
    #[Groups(['profile', 'register'])]
    protected string $email;

    #[Column]
    protected string $password;

    #[Groups(['register'])]
    #[NotBlank(groups: ['register'])]
    protected ?string $plainPassword = null;

    #[Column]
    #[NotBlank]
    #[Groups(['profile', 'register'])]
    protected string $firstName;

    #[Column]
    #[NotBlank]
    #[Groups(['profile', 'register'])]
    protected string $lastName;

    #[Column(type: 'datetime_immutable')]
    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->registeredAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegisteredAt(): DateTimeImmutable
    {
        return $this->registeredAt;
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

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
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

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }
}
