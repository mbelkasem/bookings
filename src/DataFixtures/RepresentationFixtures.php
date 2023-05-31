<?php

namespace App\DataFixtures;

use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Representation;



class RepresentationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $representations = [
            [
                'ref'=>'ayiti-201810121330',
                'show'=>'ayiti',                
                'schedule'=> ('2018-10-12 13:30:00'),
                'room' => 'Starlight Hall',
                'designation' => 'Espace Delvaux / La Vénerie',
            ],
            [
                'ref'=>'ayiti-201810122030',
                'show'=>'ayiti',                
                'schedule'=>('2018-10-12 20:30:00'),
                'room' => 'Crystal Ballroom',
                'designation' => 'Espace Delvaux / La Vénerie',
            ],
            [
                'ref'=>'cible-mouvante-201810122030',
                'show'=>'cible-mouvante',                
                'schedule'=>('2018-10-12 20:30:00'),
                'room' => 'Harmony Auditorium',
                'designation' => 'La Samaritaine',
            ],
            [
                'ref'=>'cible-mouvante-201810142030',
                'show'=>'cible-mouvante',                
                'schedule'=>('2018-10-14 20:30:00'),
                'room' => 'Royal Opera House',
                'designation' => 'Espace Magh',
            ],
            [
                'ref'=>'chanteur-belge-201810142030',
                'show'=>'ceci-n-est-pas-un-chanteur-belge',
                'schedule'=>('2018-10-14 20:30:00'),
                'room' => 'Harmony Auditorium',
                'designation' => 'Dexia Art Center',
            ],             
        ];

//$roomReference = $locationSlug . '-' . $slugify->slugify($record['room']);

        foreach ($representations as $record) {   
            $slugify= new Slugify();
            $locationSlug = $slugify->slugify($record['designation']);
            $location = $this->getReference($locationSlug); 
            $room = $this->getReference($location->getDesignation().'-'.$record['room']);

            $representation = new Representation();          
            
            $representation->setTheShow($this->getReference($record['show']));
            $representation->setSchedule(new \DateTime($record['schedule']));
            $representation->setRoom($room);
                        
            $manager->persist($representation);
            $this->addReference($record['ref'], $representation);
        }



        $manager->flush();

        
    }

    public function getDependencies() {
        return [
            LocationFixtures::class,
            ShowFixtures::class,
            RoomFixtures::class,
        ];
    }

}
