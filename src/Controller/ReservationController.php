<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\RepresentationRepository;
use App\Service\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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


    #[Route('/reservation', name: 'reservation_create', methods: ['GET'])]
    public function create(RepresentationRepository $repository,
                           SessionInterface $session,
                           StripeService $stripeService,
                           EntityManagerInterface $entityManager  ): Response
    {


        // On récupére le panier actuel
        $panier = $session->get("panier", []);


        foreach($panier as $id => $quantite){
            $representation = $repository->find($id);
            $dataPanier[] = [
                "representation" => $representation,
                "quantite" => $quantite
            ];

            $prixTotal = $representation->getTheShow()->getPrice() * $quantite;
            $reservation = new Reservation();
            $reservation->setRepresentation($representation);
            $reservation->setUser($this->getUser());
            $reservation->setPlaces($quantite);
            $reservation->setPrixTotal($prixTotal);

            // Persister la réservation dans la base de données
            $entityManager->persist($reservation);
        }

        // Exécuter les opérations d'écriture dans la base de données
        $entityManager->flush();
       return $stripeService->startPayment($reservation);
    }
}
