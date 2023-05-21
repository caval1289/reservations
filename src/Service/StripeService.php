<?php

namespace App\Service;

use App\Entity\Reservation;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StripeService
{
    private $privateKey;

    public function __construct()
    {
        if($_ENV['APP_ENV'] === 'dev'){
            $this->privateKey = $_ENV['STRIPE_SECRET_KEY_TEST'];
            \Stripe\Stripe::setApiKey($this->privateKey);
            \Stripe\Stripe::setApiVersion('2022-11-15');
        }else{
            $this->privateKey = $_ENV['STRIPE_SECRET_KEY_LIVE'];
        }
    }

    public function startPayment(Reservation $reservation){
        $unitAmount = "";

            if($reservation->getId()){
                $reservationId = $reservation->getId();
            }else{
                $reservationId= 303;
            }
            if($reservation->getRepresentation()){
                if($reservation->getRepresentation()->getTheShow() != null){
                    $unitAmount = intval($reservation->getRepresentation()->getTheShow()->getPrice() * 100);
                }else{
                    $unitAmount = 0;
                }
            }



        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'EUR',
                        'product_data' => [
                            'name' => $reservation->getRepresentation()->getTheShow()->getTitle(),
                        ],
                        'unit_amount' => $unitAmount,
                    ],
                    'quantity' => $reservation->getPlaces(),
                ],
            ],
            'mode' => 'payment',
            'success_url' => 'http://localhost:8000/success',
            'cancel_url' => 'http://localhost:8000/representation',
            'metadata' => [
                'cart_id' => $reservationId,
            ],
        ]);

        //il faut faire une redirection
        return new RedirectResponse($session->url);
    }




}