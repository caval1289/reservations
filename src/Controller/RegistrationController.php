<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SendMailService $mail, JWTService $jwt ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            //On génère le JWT de l'utilisateur
            //1-> On crée le Header

            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            //2->On crée le payload
            $payload = [
                'user_id' => $user->getId()
            ];

            //3->On crée le token
            $token = $jwt->generate($header , $payload , $this->getParameter( 'app.jwtsecret') );

            //Dump pour afficher le token
            //dd($token);


            $mail->send(
                'no-reply@reservation.be',
                $user->getEmail(),
                'Activation de votre compte',
                'register',
                [
                   'user'=>$user,
                   'token'=>$token
                ]
            );

            return $this->redirectToRoute('_profiler_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    
    

    

        
}
