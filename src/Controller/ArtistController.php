<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Repository\ArtistRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
     * @Route("/artist/nouveau/{name}", name="artist_nouveau")
     */
    public function nouveau(EntityManager $em, $name) //c'est comme instanciation et créer un objet $em 
    {
       $artiste = new Artist;
       $artiste->setName("Jimmy Hendrix");
       $artiste->setDescription("Guitariste de legende");
       // la methode "persist" de l'objet $em permet l'insertion ou la modification en BDD
       $em->persist($artiste);
        // pour exécuter les requêtes insertion ou modification en attente, il faut executer la methode "flush de l'objet $em
        $em->flush();

        return $this->redirectToRoute("artist");
        
    }


// créer une route "artist/jouter/beyounce => ça va ajouter dans la BDD un artiste beyonce, et ensuite redirection vers la route artiste"

    /**
     * @Route("/artist/ajouter", name="artist_nouveau", methods={"GET", "POST"})
     */
    public function ajouter(EntityManager $em, Request $request)
    {
        
        
        // if ($request->isMethod('POST')){
        //     $data = $request->request->all();
        //     // $data = $request->query->all(); // si type GET
        //     // voir le parameterBag pour d'autres methodes
        //     // ex : request-request->get("nom");
            
        //     $artiste = new Artist;
        //     $artiste->setName($data['nom']);
        //     $artiste->setDescription($data['description']);

        //     $em->persist($artiste);
        //     $em->flush();
        
        //     return $this->redirectToRoute("artist"); 
        // }
        
        $form = $this->createFormBuilder()
        //les types de champs du formulaire spécifique à symfony
            ->add('name', TextType::class, ['label' => 'Nom', 'attr' => ['class'=> "form-control"]])
            ->add('description', TextareaType::class, ['attr' => ['class'=> "form-control"]])
            ->getForm()
        ;
        // dd($form);
        $form->handleRequest($request); //gere le type form automatiquement

        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
        
            $artiste = new Artist;
            $artiste->setName($data['name']);
            $artiste->setDescription($data['description']);
            $em->persist($artiste);
            $em->flush();

            return $this->redirectToRoute("artist"); 

            
        }

        return $this->render('artist/create.html.twig', [
            'ajoutForm' => $form->createView()
        ]);

 
    }



}
