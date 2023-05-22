<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use http\Client\Request;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends AbstractController
{
    private $privateKey;
    private $webhookSecret;

    #[Route('/webhook', name: 'app_webhook', methods: ["POST", "GET"])]
    public function index(\Symfony\Component\HttpFoundation\Request $request,
                          LoggerInterface $logger,
                            ReservationRepository $repository,
                            EntityManagerInterface $entityManager)
    {
        if($_ENV['APP_ENV'] === 'dev'){
            $this->privateKey = $_ENV['STRIPE_SECRET_KEY_TEST'];
            \Stripe\Stripe::setApiKey($this->privateKey);
            \Stripe\Stripe::setApiVersion('2022-11-15');
        }else{
            $this->privateKey = $_ENV['STRIPE_SECRET_KEY_LIVE'];
        }

        // Check request
        $this->webhookSecret = $_ENV['STRIP_KEY_WEBHOOK'];

        $event = $request->query;
        // Parse the message body and check the signature
        $signature = $request->headers->get('stripe-signature');
        if ($this->webhookSecret) {
            try {
                $event = \Stripe\Webhook::constructEvent(
                    $request->getcontent(),
                    $signature,
                    $this->webhookSecret
                );
            } catch (\Exception $e) {
                return new JsonResponse([['error' => $e->getMessage(),'status'=>403]]);
            }
        }
        $type = $event['type'];

        // Accéder aux métadonnées de l'événement

        $logger->debug('typeType3 ' . $type);
        $metadata = $event['data']['object']['metadata'];
        $cartId = $metadata['cart_id'];
        $logger->debug('cartId ' . $cartId);

        switch ($type) {
            case 'checkout.session.completed':
                // Payment is successful and the subscription is created.
                // You should provision the subscription.
                $metadata = $event['data']['object']['metadata'];
                $cartId = $metadata['cart_id'];
                $logger->debug('Saadoun' . $cartId);

                if($cartId){
                   $reservation =  $repository->find($cartId);
                   $reservation->setPayer(true);
                   $entityManager->persist($reservation);
                   $entityManager->flush();
                }
                break;
            case 'invoice.paid':
                // Continue to provision the subscription as payments continue to be made.
                // Store the status in your database and check when a user accesses your service.
                // This approach helps you avoid hitting rate limits.
                break;
            case 'invoice.payment_failed':
                // The payment failed or the customer does not have a valid payment method.
                // The subscription becomes past_due. Notify your customer and send them to the
                // customer portal to update their payment information.
                break;
            // ... handle other event types
            default:
                // Unhandled event type
        }

        return new JsonResponse([['status'=>200]]);

    }
}
