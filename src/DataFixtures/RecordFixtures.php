<?php

namespace App\DataFixtures;

use App\Entity\Record;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class RecordFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(100, "record", function($num){
            $record = (new Record)->setTitle($this->faker->domainWord)
                                  ->setDescription($this->faker->realText(20))
                                  ->setReleasedAt($this->faker->dateTimeBetween($startDate =  '-30 years', $endDate = 'now'))
                                  ->setArtist($this->getRandomReference("artist"))
                                                // va chercher dans les fixtures artiste crées
                                ;
            return $record;
        });

            

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
    public function getDependencies(){
        //je définie quelles fixtures doivent être lancées avant la fixture actuelle
        return [ ArtistFixtures::class ];
    }
}
