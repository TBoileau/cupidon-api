<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\GraphicStyle;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class GraphicStyleCrudController extends AbstractCrudController
{
    public function __construct(private string $graphicStyleDir)
    {
    }

    public static function getEntityFqcn(): string
    {
        return GraphicStyle::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Style graphique')
            ->setEntityLabelInPlural('Styles graphiques')
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
        yield TextField::new('file', 'Image')->setFormType(VichImageType::class)->onlyOnForms();
        yield ImageField::new('filename', 'Image')->setBasePath($this->graphicStyleDir)->hideOnForm();
    }
}
