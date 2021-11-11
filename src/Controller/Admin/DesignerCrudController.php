<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Designer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

final class DesignerCrudController extends UserCrudController
{
    public static function getEntityFqcn(): string
    {
        return Designer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Designer')
            ->setEntityLabelInPlural('Designers')
            ->setDefaultSort(['registeredAt' => 'DESC']);
    }
}
