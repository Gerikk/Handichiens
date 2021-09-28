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

class RegisterController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordEncoder
     *
     * @return Response
     */
    public function index(Request $request, UserPasswordHasherInterface $passwordEncoder, SluggerInterface $slugger): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        $user->setRoles(["ROLE_FAMILLE"]);

        if ($form->isSubmitted() && $form->isValid()) {

            $photoFile = $form->get('photos')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

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
                $user->setBrochureFilename($newFilename);
            }

            $user = $form->getData();

            // Encoder le mot de passe
            $user->setPassword($passwordEncoder->hashPassword($user, $user->getPassword()));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', "Votre inscription a bien été prise en compte.");

            return $this->redirectToRoute('home');
        }


        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/educ/register", name="register_edu")
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordEncoder
     *
     * @return Response
     */
    public function index_educator(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        $user->setRoles(["ROLE_EDUCATEUR"]);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            // Encoder le mot de passe
            $user->setPassword($passwordEncoder->hashPassword($user, $user->getPassword()));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', "L'ajout d'un nouvel éducateur a bien été pris en compte.");

            return $this->redirectToRoute('dashboard');
        }


        return $this->render('register/edu.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/fam/register", name="register_fam")
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordEncoder
     *
     * @return Response
     */
    public function index_famille(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        $user->setRoles(["ROLE_FAMILLE"]);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            // Encoder le mot de passe
            $user->setPassword($passwordEncoder->hashPassword($user, $user->getPassword()));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', "L'ajout d'une nouvelle famille relais a bien été pris en compte.");

            return $this->redirectToRoute('famille_relais');
        }


        return $this->render('register/famille.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
