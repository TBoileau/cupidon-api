<?php

declare(strict_types=1);

namespace App\Controller\Api\Developer;

use App\Entity\Developer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UpdateProfile extends AbstractController
{
    public function __invoke(Developer $data): Developer
    {
        /** @var Developer $developer */
        $developer = $this->getUser();

        $developer->setGraphicStyle($data->getGraphicStyle());
        $developer->setLevel($data->getLevel());
        $developer->setEmail($data->getEmail());
        $developer->setLastName($data->getLastName());
        $developer->setFirstName($data->getFirstName());

        return $developer;
    }
}
