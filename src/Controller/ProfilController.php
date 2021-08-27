<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository){
        $this -> entityManager = $entityManager;
        $this -> userRepository = $userRepository;

    }
    /**
     * @Route("/profil", name="profil")
     */
    public function index(): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findAll();
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'user' => $user,
        ]);
    }

    /**
     * @Route("/register/{id}/edit", name="edit_profil")
     */
    public function edit(User $profil, UserPasswordEncoderInterface $passwordEncoder, Request $request)
    : Response {
        $form = $this->createForm(UserType::class, $profil);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $profil = $form->getData();

            // Encoder le mot de passe
            $profil->setPassword($passwordEncoder->encodePassword($profil, $profil->getPassword()));

            $this->entityManager->persist($profil);
            $this->entityManager->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('register/index.html.twig',
            ['form' => $form->createView()]
        );
    }
}
