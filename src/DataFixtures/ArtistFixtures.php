<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class ArtistFixtures extends BaseFixture //dans le même namespace, pas besoin d'importer la classe
{
    public function loadData(ObjectManager $manager)
    {
                        //nombre,      , function annonime
        $this->createMany(50, "artist", function($num){
            $artiste = new Artist; 
            $nom = $this->faker->randomElement(["DJ ", "MC ", "Lil ", ""]);
            $nom .= $this->faker->firstName . " ";
            $nom .=$this->faker->randomElement([
                $this->faker->realText(10),
                "aka" . $this->faker->domainWord,
                "& The " . $this->faker->lastName, 
                    ]);

            //setName() renvoie le meme objet donc on peut enchainer les set
            $artiste->setName($nom)
                    ->setDescription($this->faker->realText(20));
            return $artiste;
        });
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
