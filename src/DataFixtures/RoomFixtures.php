<?php

namespace App\DataFixtures;

use App\Entity\Room;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RoomFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $rooms = [
            [
                'name' => 'Starlight Hall',
                'seats' => 150,
            ],
            [
                'name' => 'Crystal Ballroom',
                'seats' => 200,
            ],
            [
                'name' => 'Harmony Auditorium',
                'seats' => 120,
            ],
            [
                'name' => 'Royal Opera House',
                'seats' => 300,
            ],
        ];

        
        $locations = [
            [
                'designation' => 'Espace Delvaux / La Vénerie',
            ],
            [
                'designation' => 'Dexia Art Center',
            ],
            [
                'designation' => 'La Samaritaine',
            ],
            [
                'designation' => 'Espace Magh',
            ],
        ];

      

            foreach ($locations as $recordLocations) {
                
                $slugify= new Slugify();
                $locationSlug = $slugify->slugify($recordLocations['designation']);
                $location = $this->getReference($locationSlug);
    
                foreach ($rooms as $recordRooms) {

                    $room = new Room();
                    $room->setName($recordRooms['name']);
                    $room->setSeats($recordRooms['seats']);
                    $room->setLocation($location); 
                    $this->addReference($location->getDesignation().'-'.$recordRooms['name'], $room);
                   
                    $manager->persist($room); 
                    
                }              
               
                
            }
               
        

        $manager->flush();
    }

    
    public function getDependencies(): array
    {
        return [
            LocationFixtures::class,
        ];
    }
}
