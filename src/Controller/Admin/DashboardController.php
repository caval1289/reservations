<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Artist;
use App\Entity\ArtistType;
use App\Entity\Locality;
use App\Entity\Location;
use App\Entity\Representation;
use App\Entity\Role;
use App\Entity\Show;
use App\Entity\Type;
use App\Entity\Login;
use App\Entity\Main;
use App\Entity\Registration;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/admin')]

class DashboardController extends AbstractDashboardController
{

    #[Route('/', name: 'admin_locale')]
  

    public function index(): Response
    {

         return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Reservations')
            ->renderContentMaximized();
        
    }

    public function configureMenuItems(): iterable
    {
       yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
       yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', User::class);
       yield MenuItem::linkToCrud('Artists', 'fas fa-list', Artist::class);
       yield MenuItem::linkToCrud('Shows', 'fas fa-list', Show::class);
       yield MenuItem::linkToCrud('Localities', 'fas fa-list', Locality::class);
       yield MenuItem::linkToCrud('Locations', 'fas fa-list', Location::class);
       yield MenuItem::linkToCrud('Roles', 'fas fa-list', Role::class);
       yield MenuItem::linkToCrud('Types', 'fas fa-list', Type::class);
       yield MenuItem::linkToCrud('Representations', 'fas fa-list', Representation::class);
       yield MenuItem::linkToCrud('Artist_Type', 'fas fa-list', ArtistType::class);
       yield MenuItem::linkToCrud('Artist_Type', 'fas fa-list', ArtistType::class);







    }
}
