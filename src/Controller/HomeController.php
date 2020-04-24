<?php

namespace App\Controller;

use stdClass;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $tableau = ["un", "deux", "trois", "quatre"];
        $tableau_associatif = [ "nom" => "VALISOA", 
                                "prénom" => "Heri", 
                                "age" => 5 ];
        // dump($tableau_associatif); ou dd($variable) pour dump et die 
        $objet = new stdClass; //premet de créer un objet directement et ne pas oublier d'importer la classe avec use
        // sinon utiliser la syntaxe new \stdClass.
        $objet->nom = "Mentor";
        $objet->prenom = "Gerard";
        $objet->age = "33";
        // dump($objet);
        // dump($tableau_associatif);

        return $this->render("base.html.twig", [
            "variable" => 5, 
            "tableau" => $tableau,
            "tableau_associatif" => $tableau_associatif,
            "objet" => $objet
            ]);        
    }

    /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomeController.php',
        ]);
    }
    /**
     * @Route("/livre{id}", name="afficher_livre")
     */
    public function afficher($id){ // envoyer le paramètre id dans la route
        return $this->json([
            'message' => "l'identifiant est $id", //exemple   
        ]);
    }

    // Créer une route qui va s'appeler "calcul"
    //url: /calcul/{nombre}
    // cette méthode doit retourner ce message
    // 'message'=> 

    /**
     * @Route("/calcul/{nombre}", name="afficher_livre")
     */
    public function calcul($nombre){ 

        $calcul = $nombre * 2; 
        return $this->json([
            'message' => "Le chiffre $nombre fois deux est égal à  $calcul" //exemple   
        ]);
        
    }

    /**
     * @Route("/calcul2/{nombre}", name="afficher_livre")
     */
    public function calcul2($nombre){ 
   
        // return $this->render("calcul.html.twig", [
        //     "nombre" => $nombre
        return $this->render("accueil/message.html.twig", [
             "nombre" => $nombre
        ]);

    }


}
