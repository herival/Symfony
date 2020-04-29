<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use App\Repository\RecordRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(Request $request, ArtistRepository $ar, RecordRepository $rec)

    {
        $motRecherche = $request->query->get("mot");
        $motRecherche = trim($motRecherche); //  supprimer les espaces avant et après
        // if $motRecherche != null 
        if ($motRecherche){

                $artiste = $ar->findByName($motRecherche);
                $record = $rec->findByTitle($motRecherche);
                $description = $rec->findByDescription($motRecherche);

                // dd($artiste);

                return $this->render('search/index.html.twig', [ 
                    'recherche' => $artiste , 
                    'record' => $record, 
                    'description' => $description ]);
        }
        else 
        {
            return $this->redirectToRoute('artist');
        }

    }


}
