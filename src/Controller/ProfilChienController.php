<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilChienController extends AbstractController
{
    /**
     * @Route("/profil_chien", name="profil_chien")
     */
    public function index(): Response
    {
        return $this->render('profil_chien/index.html.twig', [
            'controller_name' => 'ProfilChienController',
        ]);
    }
}
