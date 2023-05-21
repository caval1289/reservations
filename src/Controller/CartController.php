<?php

namespace App\Controller;

use App\Entity\Representation;
use App\Repository\RepresentationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'cart_index', methods: ["GET"])]
    public function index(SessionInterface $session, RepresentationRepository $representationRepository): Response
    {

        $panier = $session->get("panier", []);

        //on "fabrique" les données
        $dataPanier = [];
        $total = 0 ;

        foreach($panier as $id => $quantite){
            $representation = $representationRepository->find($id);
            $dataPanier[] = [
                "representation" => $representation,
                "quantite" => $quantite
            ];
            $total += $representation->getTheShow()->getPrice() * $quantite;

        }

        return $this->render('cart/index.html.twig', compact("dataPanier", "total"));
    }


    #[Route("/add/{id}", name: "cart_add")]
    public function add(Representation $representation, SessionInterface $session){
        // On récupére le panier actuel
        $panier = $session->get("panier", []);

        //Vérifier si le produit existe
        $id = $representation->getId();


        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }
        // On sauvegarde dans la session
        $session->set("panier",$panier);
        return $this->redirectToRoute("cart_index");
    }

    #[Route("/supp/{id}", name: "cart_supp")]
    public function sup(Representation $representation, SessionInterface $session){
        // On récupére le panier actuel
        $panier = $session->get("panier", []);

        //Vérifier si le produit existe
        $id = $representation->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }
        // On sauvegarde dans la session
        $session->set("panier",$panier);
        return $this->redirectToRoute("cart_index");
    }
    #[Route("/delete/{id}", name: "cart_delete")]
    public function delete(Representation $representation, SessionInterface $session){
        // On récupére le panier actuel
        $panier = $session->get("panier", []);

        //Vérifier si le produit existe
        $id = $representation->getId();

        if(!empty($panier[$id])){
                unset($panier[$id]);
            }

        // On sauvegarde dans la session
        $session->set("panier",$panier);
        return $this->redirectToRoute("cart_index");
    }
    #[Route("/delete", name: "carte_delete_all")]
    public function deleteAll(SessionInterface $session){
        // On récupére le panier actuel
       $session->remove("panier");

        return $this->redirectToRoute("cart_index");
    }

}
