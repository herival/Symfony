<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Repository\ArtistRepository;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ArtistController extends AbstractController
{
    /**
     * @Route("/artist", name="artist")
     */
    public function index(ArtistRepository $ar)
    {
        $liste_artistes = $ar->findAll(); //methode disponible dans ArtistRepository
        // dd($liste_artistes);
        return $this->render('artist/index.html.twig', [
            'liste_artistes' => $liste_artistes,

        ]);
    }

    /**
     * @Route("/artist/nouveau", name="artist_nouveau")
     */
    public function nouveau(EntityManager $em) //c'est comme instanciation et créer un objet $em 
    {
       $artiste = new Artist;
       $artiste->setName("Celine Dion");
       $artiste->setDescription("Diva talentuese!");
       // la methode "persist" de l'objet $em permet l'insertion ou la modification en BDD
       $em->persist($artiste);
        // pour exécuter les requêtes insertion ou modification en attente, il faut executer la methode "flush de l'objet $em
        $em->flush();

        return $this->redirectToRoute("artist");
        
    }


// créer une route "artist/jouter/beyounce => ça va ajouter dans la BDD un artiste beyonce, et ensuite redirection vers la route artiste"

}
