<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FamilleRelaisController extends AbstractController
{
    /**
     * @Route("/familles/relais", name="famille_relais")
     */
    public function index(): Response
    {
        return $this->render('famille_relais/index.html.twig', [
            'controller_name' => 'FamilleRelaisController',
        ]);
    }
}
