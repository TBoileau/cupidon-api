<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Designer;
use App\Entity\GraphicStyle;
use App\Entity\Level;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Menu\MenuItemInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DashboardController extends AbstractDashboardController
{
    #[Route(path: '/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Cupidon');
    }

    /**
     * @return iterable<MenuItemInterface>
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Styles graphiques', 'fa fa-picture-o', GraphicStyle::class);
        yield MenuItem::linkToCrud('Niveau d\'expérience', 'fa fa-briefcase', Level::class);
        yield MenuItem::linkToCrud('Designer', 'fa fa-user-circle-o', Designer::class);
    }
}
