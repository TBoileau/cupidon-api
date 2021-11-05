<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractUpdateProfile extends AbstractController
{
    public function __invoke(User $data): User
    {
        /** @var User $user */
        $user = $this->getUser();

        $user->setGraphicStyle($data->getGraphicStyle());
        $user->setLevel($data->getLevel());
        $user->setEmail($data->getEmail());
        $user->setLastName($data->getLastName());
        $user->setFirstName($data->getFirstName());
        $user->setDescription($data->getDescription());
        $user->setTwitter($data->getTwitter());
        $user->setLinkedIn($data->getLinkedIn());

        return $user;
    }
}
