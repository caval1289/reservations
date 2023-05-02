<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Locality;
use App\Repository\LocalityRepository;
use App\Form\ArtistType;

#[Route('/locality')]
class LocalityController extends AbstractController
{
    #[Route('/', name: 'locality_index', methods: ['GET'])]
    public function index(LocalityRepository $repository): Response
    {
        $locality = $repository->findAll();
        //var_dump($locality);

        return $this->render('locality/index.html.twig', [
            'locality' => $locality,
            'resource' => 'Localités',
        ]);
    }

    #[Route('/{id}', name: 'locality_show', methods: ['GET'])]
    public function show(int $id, LocalityRepository $repository): Response
    {
        //var_dump($id);
        $locality = $repository->find($id);

        return $this->render('locality/show.html.twig', [
            'locality' => $locality,
        ]);
    }
}
