<?php

namespace App\DataFixtures;

use App\Entity\Type;
use App\Entity\Mark;
use App\Entity\Seat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // Type
        $typeList=['Citadine','Berline','SUV','Break'];
        foreach ($typeList as $i){
        $type = new Type();
        $type->setTypes($i);
        $manager->persist($type);
        }
        
        //mark

        $markList=['Peugeot','Ford','Opel','Mercedes','Hyundai','Honda','Fiat','Mitsubishi'];
        foreach ($markList as $i){
        $mark = new Mark();
        $mark->setMakes($i);
        $manager->persist($mark);
        }
    
        //Seat
        $seatList=['2','4','5','7','9'];
        foreach ($seatList as $i){
        $seat = new Seat();
        $seat->setNumbers($i);
        $manager->persist($seat);
        }
        
        $manager->flush();
    }


}
