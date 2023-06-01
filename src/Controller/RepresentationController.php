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
            'representations' => $representations,
            'resource' => 'representations',
            
        ]);

    }  

    #[Route('/add', name: 'representation_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Assuming you have a User entity and a roles field
        $user = $this->getUser();
        $roles = $user->getRoles();

        if (!in_array('ROLE_ADMIN', $roles)) {
            throw new AccessDeniedHttpException('Access denied');
        }else{
            // Create a new Representation instance
                $representation = new Representation();

                // Create the form
                $representationForm = $this->createForm(RepresentationFormType::class, $representation);

                // Handle the form submission
                $representationForm->handleRequest($request);
                dd($request);
               

                // Check if the form is submitted and valid
                if ($representationForm->isSubmitted() && $representationForm->isValid()) {
                    // Get the show, room, and schedule from the form data
                    $show = $representation->getTheShow();
                    $room = $representation->getRoom();
                    $schedule = $representation->getSchedule();

                    // Set the associations between the entities
                    $representation->setTheShow($show);
                    $representation->setRoom($room);                  
                    $representation->setSchedule($schedule);

                    // Persist the representation entity
                    $em->persist($representation);
                    $em->flush();

                    // Flash a success message
                    $this->addFlash('success', 'Representation added successfully!');

                    // Redirect to a success page or perform any additional actions

                    // For example, return a redirect response to a different route
                    return $this->redirectToRoute('representation_list');
                }

                // Render the form template
                return $this->render('representation/add.html.twig', [
                    'representationForm' => $representationForm->createView(),
                ]);

        }

    
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
