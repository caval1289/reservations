<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EditProfileUserType;

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
                $this->addFlash('success', 'Profile updated');
            }

            return $this->render('users/edituser.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }

}

