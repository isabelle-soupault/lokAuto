<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Entity\Rental;
use App\Entity\User;
use App\Entity\Fleet;
use App\Entity\Mark;
use App\Entity\Seat;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        //return parent::index();
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LokAuto');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
        ->setName($user->getFullname());
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);


// Utilisateurs

        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Liste', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Ajout', 'fas fa-user-plus', User::class)->setAction('new');
        yield MenuItem::section('Locations');
        yield MenuItem::linkToCrud('Liste', 'fas fa-car', Rental::class);
        yield MenuItem::linkToCrud('Ajout', 'fas fa-user-plus', Rental::class)->setAction('new');

// Voitures

        yield MenuItem::section('Voitures');
        yield MenuItem::linkToCrud('Liste', 'fas fa-car', Car::class);
        yield MenuItem::linkToCrud('Ajout', 'fas fa-plus', Car::class)->setAction('new');
        yield MenuItem::section();

// Fleet

        yield MenuItem::section('Status');
        yield MenuItem::linkToCrud('Liste', 'fas fa-car', Fleet::class);
        yield MenuItem::linkToCrud('Ajout', 'fas fa-plus', Fleet::class)->setAction('new');
        yield MenuItem::section();

// Location

        yield MenuItem::section('Location');
        yield MenuItem::linkToCrud('Liste', 'fas fa-car', Rental::class);
        yield MenuItem::linkToCrud('Ajout', 'fas fa-plus', Rental::class)->setAction('new');
        yield MenuItem::section();

// Makes

        yield MenuItem::section('Status');
        yield MenuItem::linkToCrud('Liste', 'fas fa-car', Mark::class);
        yield MenuItem::linkToCrud('Ajout', 'fas fa-plus', Mark::class)->setAction('new');
        yield MenuItem::section();

// Seats

        yield MenuItem::section('Nombre de sièges');
        yield MenuItem::linkToCrud('Liste', 'fas fa-car', Seat::class);
        yield MenuItem::linkToCrud('Ajout', 'fas fa-plus', Seat::class)->setAction('new');
        yield MenuItem::section();
        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-sign-out-alt');

    }
}
