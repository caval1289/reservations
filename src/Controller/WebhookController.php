<?php

namespace App\Controller;


use Stripe\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends AbstractController
{

    #[Route('/webhook', name: 'webhook')]
    public function index(Request $request): Response
    {
        $stripe_webhook_secret = "whsec_a9c4f7a23a46e70882e1f043f2d6c5d59ddbcea43f96a2fe62947bb40ecab392";
        $signature = $request->headers->get('stripe-signature');
        $payload = $request->getContent();
        $event = null;

        try {
            $event = Webhook::constructEvent($payload, $signature, $stripe_webhook_secret);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return new Response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return new Response('Invalid signature', 400);
        }



     switch($event->type){
            # Handle the event
         case 'checkout.session.completed':
                //todo
         case 'customer.created':
                //todo
         case 'customer.deleted':
                //todo
         case 'invoice.payment_failed':
               //todo

}


        return new Response('Webhook handled', 200);
    }
}
