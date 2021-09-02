<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilFamilleRelaisController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository){
        $this -> entityManager = $entityManager;
        $this -> userRepository = $userRepository;
    }
    /**
     * @Route("/profil-famille-relais/{id}/", name="profil_famille_relais")
     */
    public function index(Request $request): Response
    {
        $id = $request->get('id');

        $fam = $this->entityManager->getRepository(User::class)->findById($id);
        return $this->render('famille_relais/profil.html.twig', [
            'controller_name' => 'ProfilFamilleRelaisController',
            'famille' => $fam,
        ]);
    }
}
