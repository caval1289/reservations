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

            $user->setRoles(["ROLE_USER"]);

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

            //return $this->redirect('/login/validations.html.twig');
            $this->addFlash('warning', 'Inscription en attente');
            return $this->render('registration/register_onhold.html.twig', [
                'user' => $user,
            ]);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser(string $token, JWTService $jwt, UserRepository $usersRepository, EntityManagerInterface $em): Response
    {        
        
        //On vérifie si le token est valide, n'a pas expiré et n'a pas été modifié
        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))){
            // On récupère le payload
            $payload = $jwt->getPayload($token);
            

            // On récupère le user du token
            $user = $usersRepository->find($payload['user_id']);

            //On vérifie que l'utilisateur existe et n'a pas encore activé son compte
            if($user && !$user->getIsVerified()){
                $user->setIsVerified(true);
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Utilisateur activé');
                return $this->render('registration/register_linkvalid.html.twig', [
                    'user' => $user,
                ]);
            }
        }
        // Ici un problème se pose dans le token
        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirect('/login');
    }
    
    
    #[Route('/renvoieverif' , name:'resend_verif')]

        public function resendVerif(JWTService $jwt, SendMailService $mail, UserRepository $userRepository): Response {

            $user = $this->getUser();
            if (!$user) {
                $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
                return $this->redirect('/login');
            }

            if ($user->getIsVerified()) {

                $this->addFlash('warning', 'Cette utilisateur est déja activé');
                return $this->redirect('/login'); //profil index
                
            }

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

            $this->addFlash('success', 'Email de vérification envoyé ');
                return $this->redirect('/login'); //Profile index
        } 

    
    
    

        
}
