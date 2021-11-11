<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Developer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

final class DeveloperCrudController extends UserCrudController
{
    public static function getEntityFqcn(): string
    {
        return Developer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Développeur')
            ->setEntityLabelInPlural('Développeurs')
            ->setDefaultSort(['registeredAt' => 'DESC']);
    }
}
