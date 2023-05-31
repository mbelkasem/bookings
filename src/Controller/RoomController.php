<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use App\Repository\RepresentationUserRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/room')]
class RoomController extends AbstractController
{
    #[Route('/', name: 'app_room')]
    public function index(LocationRepository $locationRepository, RoomRepository $roomRepository): Response
    {
        $locations=$locationRepository->findAll();
        $roomLocations = $roomRepository->findAll();
        return $this->render('room/index.html.twig', [
            'roomLocations' => $roomLocations,
            'locations' => $locations,
        ]);
    }

    #[Route('/{id}', name:'show_room')]
    public function showRoom(int $id, LocationRepository $locationRepository, RoomRepository $roomRepository){

        $location = $locationRepository->find(intval($id));
        $room = $roomRepository->findBy(['location'=>$location ]);

        return $this->render('room/show.html.twig', [
            'rooms' => $room,
            'location' => $location,
            
        ]);

    }
    
}
