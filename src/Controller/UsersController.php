<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}

