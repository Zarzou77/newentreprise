<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Employe;

class EmployeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         // $product = new Product();
        // $manager->persist($product);
        
        for($i=1; $i<= 15; $i++){
            $employe = new Employe;
            $employe->setPrenom("prenom n°$i)")
                    ->setNom ("nom n°$i")
                    ->setTelephone ("telephone n°$i" )
                    ->setEmail (" email$i@gmail.com ")
                    ->setAdresse("adresse $i")
                    ->setPoste("poste n°$i")
                    ->setSalaire($i)
                    ->setDateDeNaissance("22/07/1987");
            $manager->persist($employe);
        }
           
            
        $manager->flush();
    }
}
