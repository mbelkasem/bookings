<?php

namespace App\Controller;

use App\Repository\ShowRepository;
use App\Repository\UserCommentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/usercomment')]
class UserCommentController extends AbstractController
{
    #[Route('/', name: 'app_usercomment')]
    public function index(ShowRepository $showRepository): Response
    {
        $show = $showRepository->findAll();
        return $this->render('usercomment/index.html.twig', [
            'shows' => $show,
        ]);
    }

    #[Route('/{showslug}', name: 'show_comment', methods: ['GET'])]
    public function show(string $showslug, ShowRepository $showRepository, UserCommentRepository $userCommentRepository): Response
    {
        $show = $showRepository->findOneBy(['slug' => $showslug]);

        if (!$show) {
            throw $this->createNotFoundException('Show not found');
        }

       $userComments = $userCommentRepository->findBy(['show' => $show]);

        return $this->render('usercomment/show.html.twig', [
            'show' => $show,
            'userComments' =>$userComments,
        ]);
    }
}
