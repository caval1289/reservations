<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Artist;
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
#[IsGranted(["ROLE_ADMIN"])]
class DashboardController extends AbstractDashboardController
{

    #[Route('/', name: 'admin_locale')]
    #[IsGranted(["ROLE_ADMIN"])]

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
    }
}
