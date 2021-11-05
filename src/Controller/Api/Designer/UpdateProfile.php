<?php

declare(strict_types=1);

namespace App\Controller\Api\Designer;

use App\Entity\Designer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UpdateProfile extends AbstractController
{
    public function __invoke(Designer $data): Designer
    {
        /** @var Designer $designer */
        $designer = $this->getUser();

        $designer->setGraphicStyle($data->getGraphicStyle());
        $designer->setLevel($data->getLevel());
        $designer->setEmail($data->getEmail());
        $designer->setLastName($data->getLastName());
        $designer->setFirstName($data->getFirstName());

        return $designer;
    }
}
