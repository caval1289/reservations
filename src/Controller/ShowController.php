<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Show;
use App\Repository\ShowRepository;
use App\Form\ShowType;
use Symfony\Component\Form\FormError;

#[Route('/show')]

class ShowController extends AbstractController

{
    #[Route('/', name: 'show_index', methods: ['GET'])]
    public function index(ShowRepository $repository): Response
    {
        $shows = $repository->findAll();


        return $this->render('show/index.html.twig', [
            'shows' => $shows,
            'resource' => 'Liste des spectacles',
        ]);
    }
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/new', name: 'show_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ShowRepository $showRepository): Response
    {
        $show = new Show($this->entityManager);
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $showRepository->save($show, true);

            return $this->redirectToRoute('show_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('show/new.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/{id}', name: 'show_delete', methods: ['DELETE', 'POST'])]
    public function delete(Request $request, Show $show, showRepository $showRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $show->getId(), $request->request->get('_token'))) {
            $showRepository->remove($show, true);
        }

        return $this->redirectToRoute('show_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}', name: 'show_show', methods: ['GET'])]
    public function show(int $id, ShowRepository $repository): Response
    {

        $show = $repository->find($id);

        //Récupérer les artistes du spectacle et les grouper par type
        $collaborateurs = [];

        foreach ($show->getArtistTypes() as $at) {
            $collaborateurs[$at->getType()->getType()][] = $at->getArtist();
        }

        return $this->render('show/show.html.twig', [
            'show' => $show,
            'collaborateurs' => $collaborateurs,
        ]);
    }

    #[Route('/{id}/edit', name: 'show_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Show $show, ShowRepository $showRepository): Response
    {
        $collaborateurs = [];
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);
        foreach ($show->getArtistTypes() as $at) {
            $collaborateurs[$at->getType()->getType()][] = $at->getArtist();
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $show->setTitle($data->getTitle());
            $show->setDescription($data->getDescription());
            $show->setPosterUrl($data->getPosterUrl());
            $show->setPrice($data->getPrice());
            $show->setLocation($data->getLocation());
            // Récupérer les artistTypes sélectionnés
            $selectedArtistTypes = $data->getArtistTypes();
            // Mettre à jour les artistTypes du spectacle
            $show->setArtistTypes($selectedArtistTypes);

            // Enregistrer les modifications
            $showRepository->save($show, true);
            return $this->redirectToRoute('show_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('show/edit.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
            'collaborateurs' => $collaborateurs,
        ]);
    }
}
