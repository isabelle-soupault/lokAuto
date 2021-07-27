<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Entity\Rental;
use App\Entity\User;
use App\Entity\Fleet;
use App\Entity\Mark;
use App\Entity\Seat;
use App\Entity\Type;
use App\Repository\UserRepository;
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
        $em = $this->getDoctrine()->getManager();
        $usersRepository = $em->getRepository(User::class);
        $carsRepository = $em->getRepository(Car::class);
        $rentalsRepository = $em->getRepository(Rental::class);
        //$userNbr = $usersRepository->countUsers();
        return $this->render('admin/dashboard.html.twig', ['users' => $usersRepository->countUsers(), 
        'cars' => $carsRepository->countCars(),
        'rentals'=> $rentalsRepository->countRentals()
    ]);
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
yield MenuItem::linktoDashboard('Dashboard', 'fas fa-tachometer-alt');
yield MenuItem::linkToUrl('Accueil', 'fa fa-home','/' );
yield MenuItem::linkToLogout('Déconnexion', 'fa fa-sign-out-alt');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);

// Utilisateurs
yield MenuItem::section('Utilisateurs');
yield MenuItem::linkToCrud('Liste', 'fas fa-users', User::class);
yield MenuItem::linkToCrud('Ajout', 'fas fa-user-plus', User::class)->setAction('new');

// Location
yield MenuItem::section('Locations');
yield MenuItem::linkToCrud('Liste', 'fas fa-folder-open', Rental::class);
yield MenuItem::linkToCrud('Ajout', 'fas fa-plus', Rental::class)->setAction('new');

// Fleet
yield MenuItem::section('Status');
yield MenuItem::linkToCrud('Liste', 'fas fa-cogs', Fleet::class);
yield MenuItem::linkToCrud('Ajout', 'fas fa-plus', Fleet::class)->setAction('new');

// Voitures
yield MenuItem::section('Voitures');
yield MenuItem::linkToCrud('Liste', 'fas fa-car', Car::class);
yield MenuItem::linkToCrud('Ajout', 'fas fa-plus', Car::class)->setAction('new');

//Types
yield MenuItem::section('Type de véhicule');
yield MenuItem::linkToCrud('Liste', 'fas fa-chair', Type::class);
yield MenuItem::linkToCrud('Ajout', 'fas fa-plus', Type::class)->setAction('new');

// Makes
        yield MenuItem::section('Marques');
        yield MenuItem::linkToCrud('Liste', 'fas fa-copyright', Mark::class);
        yield MenuItem::linkToCrud('Ajout', 'fas fa-plus', Mark::class)->setAction('new');

// Seats
        yield MenuItem::section('Nombre de sièges');
        yield MenuItem::linkToCrud('Liste', 'fas fa-chair', Seat::class);
        yield MenuItem::linkToCrud('Ajout', 'fas fa-plus', Seat::class)->setAction('new');
        
    }

    public function showUserNumber(UserRepository $userRepo){
        $userNbr = $userRepo->countUsers();
        return $this->render('admin/dashboard.html.twig', ['users' => $userNbr]);
    }
}
