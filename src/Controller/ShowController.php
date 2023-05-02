<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Show;
use App\Repository\ShowRepository;

#[Route('/show')]

class ShowController extends AbstractController

{#[Route('/', name:'show_index', methods: ['GET'])]
    public function index(ShowRepository $repository): Response
    {
        $shows = $repository->findAll();
       

        return $this->render('show/index.html.twig', [
            'shows' => $shows,
            'resource' => 'Liste des spectacles',
        ]);

    }  
    
    #[Route('/{id}', name:'show_show', methods: ['GET'])]
    public function show(int $id, ShowRepository $repository): Response
    {
       
        $show = $repository->find($id);

        //Récupérer les artistes du spectacle et les grouper par type
        $collaborateurs = [];

        foreach($show->getArtistTypes() as $at) {
            $collaborateurs[$at->getType()->getType()][] = $at->getArtist();
        }


        return $this->render('show/show.html.twig', [
            'show' => $show,
            'collaborateurs' => $collaborateurs,
        ]);
    }
}
