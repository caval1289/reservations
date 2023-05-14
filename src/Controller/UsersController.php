<?php

namespace App\Controller;

use App\Form\EditProfileUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\ChangePasswordType;



class UsersController extends AbstractController
{
    #[Route('/user', name: 'user_profil')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('users/user.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/edit', name: 'user_profil_edit')]
    public function editUserProfil(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Profile utilisateur mis à jour');
        }

        return $this->render('users/edituser.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]); 
    }

 

    #[Route('/user/changepwd', name: 'user_profil_pwd')]
        public function editUserPassword(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher): Response
        {
            $user = $this->getUser();
            $form = $this->createForm(ChangePasswordType::class);
            $form->handleRequest($request);

            $pwdFisrt = $form->get('password')['first']->getData();
            $pwdSecond = $form->get('password')['second']->getData();
                    
            if ($request->getMethod() == 'POST') {
                
                if ($pwdFisrt === $pwdSecond) {
                    // encode the plain password
                    $user->setPassword(
                        $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('password')->getData()
                        )
                    );
            
                    $this->addFlash('success', 'Mot de passe mis à jour');
                    $em->persist($user);
                    $em->flush();
                    
                    return $this->redirectToRoute('user_profil');
                } else {                    
                   
                    $this->addFlash('warning', 'Les deux mots de passe ne sont pas identiques');                    
                }
            
            }

            

            return $this->render('users/pwduser.html.twig', [
                'form' => $form->createView(),
            ]);
        }


}




