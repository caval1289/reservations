<?php

namespace App\Manager;

use App\Entity\Representation;
use App\Entity\Reservation;
use App\Entity\User;
use App\Service\StripeService;
use Doctrine\ORM\EntityManagerInterface;

class RepresentationManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var StripeService
     */
    protected $stripeService;

    /**
     * @param EntityManagerInterface $entityManager
     * @param StripeService $stripeService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        StripeService $stripeService
    ){
        $this->em = $entityManager;
        $this->stripeService =$stripeService;
    }

    public function getRepresentations(){
        return $this->em->getRepository(Representation::class)->findAll();
    }

    public function intentSecret(Representation $representation){
        $intent = $this->stripeService->paymentIntent($representation);
        return $intent['client_secret'] ?? null;
    }

    public function stripe(array $stripeParameter, Representation $representation){
        $resource = null;
        $data = $this->stripeService->stripe($stripeParameter, $representation);

        if($data){
            $resource= [
                'stripeBrand' => $data['charges']['data'][0]['payment_method_details']['card']['brand'],
                'stripeLast4' => $data['charges']['data'][0]['payment_method_details']['card']['last4'],
                'stripeId' => $data['charges']['data'][0]['id'],
                'stripeStatus' => $data['charges']['data'][0]['status'],
                'stripeToken' => $data['client_secret'],
            ];
        }
        return $resource;
    }

    /**
     * @param array $resource
     * @param Representation $representation
     * @param User $user
     * @return void
     */
    public function create_subscription(array $resource, Representation $representation, User $user){
        $order = new Reservation();
        $order->setUser($user);
        $order->setRepresentation($representation);

        //$order->setPrice($representation->getTheshow->getPrice);
        //$order->setReference( uniqid('', false));
        //$order->setBrandStripe($resource['stripeBrand']);  il faut rajouter use StripeTrait dans l'entité Order
        //$order->setLast4Stripe();
        //$order->setIdChargesStripe();
        //$order->setStripeToken();
        //$order->setStatusStripe();
        //$order->setUpdatedAt(new \Datetime());
        //$order->setCreatedAt(new \Datetime());

        $this->em->persist($order);
        $this->em->flush();

    }

}