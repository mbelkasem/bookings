<?php

namespace App\Controller;

use App\Entity\Lieufavoris;
use App\Entity\User;
use App\Repository\LieufavorisRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lieufavoris')]
class LieuFavorisController extends AbstractController
{
    #[Route('/', name: 'app_lieu_favoris')]
    public function index(LieufavorisRepository $lieufavorisRepository): Response
    {
        $lieuxfavoris =$lieufavorisRepository->findAll();
        
        return $this->render('lieu_favoris/index.html.twig', [
            'lieuxfavoris' =>$lieuxfavoris,
        ]);
    }

    #[Route('/{userlogin}', name: 'lieufavoris_show', methods: ['GET'])]
    public function show(string $userlogin, UserRepository $userRepository, LieufavorisRepository $lieufavorisRepository): Response
    {
        $user = $userRepository->findOneBy(['login' => $userlogin]);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $lieuxfavoris = $lieufavorisRepository->findBy(['user' => $user]);

        return $this->render('lieu_favoris/show.html.twig', [
            'user' => $user,
            'lieuxfavoris' => $lieuxfavoris,
        ]);
}

    
}
