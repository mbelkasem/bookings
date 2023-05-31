<?php

namespace App\Controller;

use App\Entity\Representation;
use App\Form\RepresentationFormType;
use App\Repository\RepresentationRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/representation')]

class RepresentationController extends AbstractController
{
    #[Route('/', name:'representation_index', methods: ['GET'])]
    public function index(RepresentationRepository $repository): Response
    {
        $representations = $repository->findAll();
        
       
        return $this->render('representation/index.html.twig', [
            'representation' => $representations,
            'resource' => 'representations',
            
        ]);

    }  

    #[Route('/add', name: 'representation_add', methods: ['GET'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Assuming you have a User entity and a roles field
        $user = $this->getUser();
        $roles = $user->getRoles();

        if (!in_array('ROLE_ADMIN', $roles)) {
            throw new AccessDeniedHttpException('Access denied');
        }

        // On crée une nouvelle Représentation
        $representation = new Representation();

        // On crée le formulaire
        $representationForm = $this->createForm(RepresentationFormType::class, $representation);   
        
        //On traite la requête du formulaire

        $representationForm->handleRequest($request);
        //dd($representationForm);

        

        return $this->render('representation/add.html.twig', [
            'representationForm' => $representationForm->createView(),
        ]);
    }

    #[Route('/{id}', name:'representation_show', methods: ['GET'])]
    public function show(int $id, RepresentationRepository $repository, RoomRepository $roomRepository): Response
    {
        $representations = $repository->find($id);
        $room = $representations->getRoom();
       
        return $this->render('representation/show.html.twig', [
            'representation' => $representations,
            'room'=>$room,
            
        ]);

    }   

    
    
}
