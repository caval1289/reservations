<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Type;
use App\Repository\TypeRepository;
use App\Form\ArtistType;


#[Route('/type')]
class TypeController extends AbstractController
{
    #[Route('/', name:'type_index', methods: ['GET'])]
    public function index(TypeRepository $repository): Response
    {
        $type = $repository->findAll();
       // var_dump($type);

        return $this->render('type/index.html.twig', [
            'type' => $type,
            'resource' => 'types',
        ]);

    }  

    #[Route('/{id}', name:'type_show', methods: ['GET'])]
    public function show(int $id, TypeRepository $repository): Response
    {
        //var_dump($id);
        $type = $repository->find($id);

        return $this->render('type/show.html.twig', [
            'type' => $type,
        ]);
    }

}
