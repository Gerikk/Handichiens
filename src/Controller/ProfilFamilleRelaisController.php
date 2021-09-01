<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilFamilleRelaisController extends AbstractController
{
    /**
     * @Route("/profil-famille-relais", name="profil_famille_relais")
     */
    public function index(): Response
    {
        return $this->render('famille_relais/profil.html.twig', [
            'controller_name' => 'ProfilFamilleRelaisController',
        ]);
    }
}
