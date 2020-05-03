<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    /**
     * @Route("/User_profile", name="profil")
     */
    public function index()
    {

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    /**
     * @Route("/profil/liste", name="liste_utilisateurs")
     */
    public function liste_utilisateurs(UserRepository $user)
    {
        $liste_utilisateurs = $user->findAll();

        // dd($liste_utilisateurs);
        return $this->render('profil/liste.html.twig', [
            'liste_utilisateur' => $liste_utilisateurs,
        ]);
    }

}
