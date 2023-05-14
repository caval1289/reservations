<?php

namespace App\Controller;

use App\Form\ResetPasswordForm;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/')]
class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

#[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

#[Route('/forgetpassword', name: 'app_forgetpassword')]

    public function forgetpassword(Request $request, UserRepository $userRepository,
    TokenGeneratorInterface $tokenGeneratorInterface, EntityManagerInterface $em, SendMailService $mail):Response{

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()){
            
            //On check si l'utilisateur existe par son email
            $user = $userRepository->findOneByEmail($form->get('email')->getData()); 
            //dd($user); //Si on met l'email d'un utilisateur existant, il renvoie toute les informations de l'utilisateur

            //On vérifie si on a un utilisateur
            
            if ($user){

                //1. On génére un token de réinitialisation pour l'utilisateur
                $token = $tokenGeneratorInterface->generateToken();
                //dd($token);	//Vérifie qu'on génére bien un token unique
                $user->setResetToken($token);
                $em->persist($user);
                $em->flush();

                //2. On génére un lien de réinitialisation du mot de passe
                $url = $this->generateUrl('reset_pass', ['token' => $token],UrlGeneratorInterface::ABSOLUTE_URL);
                //dd($url); //on vérfie que URL Generator a bien généré une url complete pour la réinitialisation

                //3.On crée le mail de réinitialisation
                $context = [
                    'url' => $url,
                    'user'=>$user,
                ];

                //4. On envoie le mail
                $mail->send(
                    'no-reply@reservation.be',
                    $user->getEmail(),
                    'Réinitialisation du mot de passe',
                    'password_reset',
                    $context
                );

                $this->addFlash('success', 'Un email de réinitialisation a été envoyé');
                return $this->redirect('/login');
 

            }
             
            //Si $user est null
            $this->addFlash('danger', 'Un problème est survenue');
            return $this->redirect('login');
        }


            return $this->render('login/reset_passsword.html.twig', [
            'requestPasswords' => $form->createView()  
             ]);
    }

    #[Route('/forgetpassword/{token}', name:'reset_pass')]

        public function resetPass(string $token, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManagerInterface,
        UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em):Response{
            
            //1.Vérifier si on a le token dans la base de donnée
            $user = $userRepository->findOneByResetToken($token);
            //dd($user); Vérifie qu'on récupére bien le token de l'utilsateur

            if ($user){
                $form = $this->createForm(ResetPasswordForm ::class);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()){
                    //On efface le token
                    $user->setResetToken('');
                    $user->setPassword(
                        $passwordHasher->hashPassword(
                            $user,
                            $form->get('password')->getData()
                        )
                    );
                    $em->persist($user);
                    $em->flush();

                    $this->addFlash('success','Mot de passe changé avec success');
                    return $this->redirect('/login');
                }


                return $this->render('login/reset_passswordForm.html.twig', [
                    'passForm'=>$form->createView()
                ]);


            }

            $this->addFlash('danger', 'Jeton invalide');
            return $this->redirect('/login');

        }
}

