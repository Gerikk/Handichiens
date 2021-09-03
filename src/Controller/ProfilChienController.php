<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Chien;
use App\Form\NewChienType;
use App\Form\ChienType;
use App\Repository\ChienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class ProfilChienController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager, ChienRepository $chienRepository){
        $this -> entityManager = $entityManager;
        $this -> chienRepository = $chienRepository;
    }

    /**
     * @Route("/profil_chien/{id}", name="profil_chien")
     */
    public function index(Request $request, Chien $chien): Response
    {
        return $this->render('profil_chien/index.html.twig', [
            'controller_name' => 'ProfilChienController',
            'chien' => $chien,
        ]);
    }
}
