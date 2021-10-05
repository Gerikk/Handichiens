<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this -> entityManager = $entityManager;
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
     * @Route("/profil/{id}/edit", name="edit_profil")
     */
    public function edit(User $profil, UserPasswordHasherInterface $passwordEncoder, SluggerInterface $slugger, Request $request)
    : Response {
        $form = $this->createForm(UserType::class, $profil);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photos')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid('', true).'.'.$photoFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $profil->setBrochureFilename($newFilename);
            }

            $profil = $form->getData();

            // Encoder le mot de passe
            $profil->setPassword($passwordEncoder->hashPassword($profil, $profil->getPassword()));

            $this->entityManager->persist($profil);
            $this->entityManager->flush();

            $this->addFlash('success', "La modification a bien été prise en compte.");

            return $this->redirectToRoute('profil');
        }

        return $this->render('profil/edit.html.twig',
            ['form' => $form->createView()]
        );
    }
}
