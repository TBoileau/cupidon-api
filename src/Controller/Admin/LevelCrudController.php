<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Level;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class LevelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Level::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Niveau d\'expérience')
            ->setEntityLabelInPlural('Niveaux d\'expérience')
            ->setDefaultSort(['name' => 'ASC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    /**
     * @return iterable<FieldInterface>
     */
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'Identifiant')->hideOnForm();
        yield TextField::new('name', 'Nom');
        yield TextField::new('description', 'Description');
    }
}
