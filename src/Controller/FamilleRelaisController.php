<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FamilleRelaisController extends AbstractController
{
    /**
     * @Route("/les-familles-relais", name="famille_relais")
     */
    public function index(): Response
    {
        return $this->render('famille_relais/index.html.twig', [
            'controller_name' => 'FamilleRelaisController',
        ]);
    }

    /**
     * @Route("/les-familles-relais", name="famille_relais")
     */
    public function findFamille(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(User::class);
        $familles = $repository->findAll();

        return $this->render('famille_relais/index.html.twig', [
            'familles' => $familles,
        ]);
    }
}
