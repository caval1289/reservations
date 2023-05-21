<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\RepresentationRepository;
use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/panier/{id}', name: 'reservation_panier', methods: ['GET'])]
    public function index(string $id, RepresentationRepository $repository): Response
    {
        $id = intval($id);
        $representation = $repository->find($id);
        return $this->render('reservation/index.html.twig', [
            'representation' => $representation,
        ]);
    }


    #[Route('/{id}', name: 'reservation_create', methods: ['POST'])]
    public function create(string $id, RepresentationRepository $repository,
                           Request $request,
                           StripeService $stripeService): Response
    {
        $id = intval($id); // conversion en entier
        $representation = $repository->find($id);

        // Récupérer le nombre de place
        $nombrePlaces = $request->request->get('nb_places');
        $nombrePlaces = intval($nombrePlaces);


        //recalculer le prix total
        //$prixTotal = $nombrePlaces * $representation->getTheShow()->getPrice() ;

        $reservation = new Reservation();
        $reservation->setRepresentation($representation);
        $reservation->setUser($this->getUser());
        $reservation->setPlaces($nombrePlaces);



       return $stripeService->startPayment($reservation);
    }
}
