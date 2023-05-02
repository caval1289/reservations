<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Repository\LocationRepository;

#[Route('/location')]

class LocationController extends AbstractController
{
    #[Route('/', name:'location_index', methods: ['GET'])]
    public function index(LocationRepository $repository): Response
    {
        $locations = $repository->findAll();
       

        return $this->render('location/index.html.twig', [
            'location' => $locations,
            'resource' => 'lieux',
        ]);

    }  

    #[Route('/{id}', name:'location_show', methods: ['GET'])]
    public function show(int $id, LocationRepository $repository): Response
    {
       
        $locations = $repository->find($id);

        return $this->render('location/show.html.twig', [
            'location' => $locations,
        ]);
    }
}

