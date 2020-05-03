<?php

namespace App\Controller;

use App\Entity\Ranking;
use App\Form\RankingType;
use App\Repository\RecordRepository;
use App\Repository\RankingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RankingController extends AbstractController
{
    /**
     * @Route("/ranking", name="ranking")
     */
    public function index()
    {
        return $this->render('ranking/index.html.twig', [
            'controller_name' => 'RankingController',
        ]);
    }

    /**
     * @Route("/ranking/new/record{id}", name="new_ranking")
     */
    public function newRanking($id, Request $req, EntityManagerInterface $em, RecordRepository $rec)
    {

        $record = $rec->find($id);

        $nvRanking = new Ranking; 
        
        $user = $this->getUser();
        $nvRanking->setUser($user);
        $nvRanking->setRecord($record);
        

        $formRanking = $this->createForm(RankingType::class, $nvRanking);
        $formRanking->handleRequest($req);

        if ($formRanking->isSubmitted() && $formRanking->isValid()){

            $em->persist($nvRanking); 
            $em->flush();


            return $this->redirectToRoute("record_single", ['id' => $id]);
            // return $this->redirect("../../single/record/$id");
        }
        
        return $this->render('ranking/index.html.twig', [
            "form"=>$formRanking->createView(),
        ]);
    }
}
