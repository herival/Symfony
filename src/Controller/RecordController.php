<?php

namespace App\Controller;

use App\Entity\Record;
use App\Form\RecordType;
use App\Repository\RecordRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecordController extends AbstractController
{
    /**
     * @Route("/record", name="record")
     */
    public function index(RecordRepository $rec)
    {

        $liste_records = $rec->findAll();

        return $this->render('record/index.html.twig', [
            'liste_records' => $liste_records,
        ]);
    }

    /**
     * @Route("/record/new", name="new_record")
     */
    public function newRecord(Request $request, EntityManager $em)
    {
        $nvRecord = new Record;
        $formRecord = $this->createForm(RecordType::class, $nvRecord); // il fait appel à la classe ArtistType créer par le form validator
        //ne pas oublier de mettre en paramètre l'instance $nvArtist
        $formRecord->handleRequest($request);
        
        if($formRecord->isSubmitted() && $formRecord->isValid()){

            $em->persist($nvRecord);
            $em->flush();

            return $this->redirectToRoute("record");
        }

        return $this->render("record/formRecord.html.twig", 
                    ["form" => $formRecord->createView(), 'titre'=> 'Nouveau Record', 'bouton'=>'Enregistrer' ]);

    }

    /**
     * @Route("/record/modifier/{id}", name="modifier")
     */
    public function modifier(EntityManager $em, Request $request, $id, RecordRepository $rec)
    {

        $record = $rec->find($id);

        $formRecord = $this->createForm(RecordType::class, $record); 
        $formRecord->handleRequest($request);
        
        if($formRecord->isSubmitted() && $formRecord->isValid()){

            // plus besoin de persister pour la modification
            $em->flush();

            return $this->redirectToRoute("record");
        }

        return $this->render("record/formRecord.html.twig", 
        ["form" => $formRecord->createView() , 'titre'=> 'Edition Record', 'bouton'=>'Modifier']);
    }

    /**
     * @Route("/record/supprimer/{id}", name="supprimer_record")
     */
    public function supprimer_record($id, RecordRepository $rec, Record $record){
        $record = $rec->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($record);
        $em->flush();

        return $this->redirectToRoute("record");

    }

    
    /**
     * @Route("single/record/{id}", name="record_single")
     */
    public function record_single($id, RecordRepository $rec){
        $record = $rec->find($id);
        // dd($record);
        if (!empty($record)){
            return $this->render('record/singleRecord.html.twig', ["record" => $record]);
        }

        return $this->redirectToRoute("record");

    }


}
