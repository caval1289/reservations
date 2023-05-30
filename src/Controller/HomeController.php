<?php

namespace App\Controller;

use App\Entity\Show;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/')]
class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'home_index')]
    public function index(): Response
    {
        $showRepository = $this->entityManager->getRepository(Show::class);
        $shows = $showRepository->findAll();

        return $this->render('home/index.html.twig', [
            'shows' => $shows,
        ]);
    }
}