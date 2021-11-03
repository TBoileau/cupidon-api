<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[Entity]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'discr', type: 'string')]
#[DiscriminatorMap(['designer' => Designer::class, 'developer' => Developer::class])]
#[Table(name: '`user`')]
#[UniqueEntity(fields: 'email')]
abstract class User extends BaseUser
{
    #[ManyToOne(targetEntity: Level::class)]
    #[JoinColumn(nullable: false)]
    #[ApiProperty(readableLink: false, writableLink: false)]
    protected Level $level;

    #[ManyToOne(targetEntity: GraphicStyle::class)]
    #[JoinColumn(nullable: false)]
    #[ApiProperty(readableLink: false, writableLink: false)]
    protected GraphicStyle $graphicStyle;

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
}
