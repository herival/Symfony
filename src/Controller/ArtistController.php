<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use App\Repository\RecordRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//Pour pouvoir utiliser l'annotation IsGranted
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ArtistController extends AbstractController
{

    /**
     * @Route("/artist", name="artist")
     * @IsGranted("ROLE_ADMIN")
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

            $nom = $data['name'];
            $this->addFlash('success', "L'artiste \"$nom\" a bien été ajouté!");

            return $this->redirectToRoute("artist"); 

            
        }

        return $this->render('artist/create.html.twig', 
        ['ajoutForm' => $form->createView()]
        );

 
    }

    /**
     * @Route("/artist/supprimer/{id}", name="supprimer_artiste")
     */
    public function supprimerArtiste(Artist $artist, $id, ArtistRepository $ar){

        $artist = $ar->find($id);
        $nom = $artist->getName(); // utilise le getter pour recuperer
        $em = $this->getDoctrine()->getManager();
        // dd($em);
        $em->remove($artist);
        $em->flush();
        $this->addFlash("danger", "L'artiste \"$nom\" a bien été supprimé!"); //envoyer dans la session, accessible partout dans la page
     
        
        return $this->redirectToRoute("artist");

    }

    /**
     * @Route("/artist/new", name="artist_add")
     */
    public function new(Request $request, EntityManager $em)
    {
        $nvArtiste = new Artist;
        $formArtiste = $this->createForm(ArtistType::class, $nvArtiste); // il fait appel à la classe ArtistType créer par le form validator
        //ne pas oublier de mettre en paramètre l'instance $nvArtist
        $formArtiste->handleRequest($request);
        
        if($formArtiste->isSubmitted() && $formArtiste->isValid()){
            $nom = $nvArtiste->getName();
            // $data = $formArtiste->getData();

            // dd($data->get('name'));
            // $nvArtiste->setName($data['name']);
            // $nvArtiste->setDescription($data['description']);
            $em->persist($nvArtiste);
            $em->flush();
            $this->addFlash("success","L'artiste \"$nom\" a bien été ajouté!");

            return $this->redirectToRoute("artist");
        }

        return $this->render("artist/form.html.twig", 
                    ["form" => $formArtiste->createView() ]);

    }

 

    /**
     * @Route("/fiche/artist/single/{id}", name="single", requirements={"id"="\d+"})
     * requirements : id doit être composé d'un ou plusieurs chiffres
     * 
     */
    public function single($id, ArtistRepository $ar)
    {
        $artist = $ar->find($id);
        // $records = $rec->findRecord(6);
        if (!empty($artist)){
            return $this->render('artist/single.html.twig', ["artiste" => $artist]);
        }
        return $this->redirectToRoute('artist');
    }

    /**
     * @Route("/artist/modifier/{id}", name="modifier_artist")
     */
    public function modifier_artiste(EntityManager $em, Request $request, $id, ArtistRepository $ar){
        
        $artist = $ar->find($id);

        $formArtist = $this->createForm(ArtistType::class, $artist);
        $formArtist->handleRequest($request);

        if($formArtist->isSubmitted() && $formArtist->isValid()){
            // plus besoin de persister pour la modification
            $em->flush();

            return $this->redirectToRoute("artist");
        }
        return $this->render("artist/form.html.twig", 
        ["form" => $formArtist->createView() , 'titre'=> 'Edition Artiste', 'bouton'=>'Modifier']);

    }






}
