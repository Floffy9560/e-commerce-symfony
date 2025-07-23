<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Item;
use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator) {}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Redirection directe vers le CRUD User
        return $this->redirect(
            $this->adminUrlGenerator
                ->setController(\App\Controller\Admin\UserCrudController::class)
                ->generateUrl()
        );

        // return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mon Backoffice');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Gestion des utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);

        yield MenuItem::section('Produits');
        yield MenuItem::linkToCrud('Articles', 'fa fa-box', Item::class);

        yield MenuItem::section('Commandes');
        yield MenuItem::linkToCrud('Commandes', 'fa fa-shopping-cart', Order::class);

        yield MenuItem::section('Autre');
        yield MenuItem::linkToRoute('Retour au site', 'fa fa-arrow-left', 'app_index');
    }
}
