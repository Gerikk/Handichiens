<?php

namespace App\Controller;

use App\Repository\ChienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Chien;
use App\Form\NewChienType;
use Symfony\Component\String\Slugger\SluggerInterface;



class ChiensController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager, ChienRepository $chienRepository){
        $this -> entityManager = $entityManager;
        $this -> chienRepository = $chienRepository;
    }


    private function addImage(){

    }
    /**
     * @Route("/chiens", name="chiens")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $chiens = $entityManager->getRepository(Chien::class)->findAll();
        return $this->render('chiens/index.html.twig', [
            'controller_name' => 'ChiensController',
            'chiens' => $chiens
        ]);
    }

    /**
     * @Route("/chiens/ajouter", name="chiens_ajouter")
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
            // just setup a fresh $task object (remove the example data)
            $task = new Chien();

            $form = $this->createForm(NewChienType::class, $task);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $imgFile = $form->get('photos')->getData();
                if ($imgFile) {
                    $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imgFile->guessExtension();

                    try {
                        $imgFile->move(

                            $this->getParameter('photos_directory'),

                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    $task->setImg($newFilename);
                }
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $task = $form->getData();

                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($task);
                $entityManager->flush();

                $this->addFlash('success', "L'ajout d'un nouveau chien a bien été pris en compte.");

                return $this->redirectToRoute('chiens');
            }

            return $this->render('chiens/new.html.twig', [
                'form' => $form->createView(),
            ]);
        }

    /**
     * @Route("/profil_chien/{id}", name="profil_chien")
     */
    public function indexProfil(Request $request, Chien $chien): Response
    {
        return $this->render('profil_chien/index.html.twig', [
            'controller_name' => 'ProfilChienController',
            'chien' => $chien,
        ]);
    }

    /**
     * @Route("/profil_chien/{id}/edit", name="edit_profil_chien")
     */
    public function edit(Chien $profil, SluggerInterface $slugger, Request $request): Response {
        $form = $this->createForm(NewChienType::class, $profil);
        $id = $request->get('id');
        $ch = $this->entityManager->getRepository(Chien::class)->findById($id);

        $form->handleRequest($request);
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
                $profil->setImg($newFilename);
            }

            $profil = $form->getData();

            $this->entityManager->persist($profil);
            $this->entityManager->flush();

            $this->addFlash('success', "La modification a bien été prise en compte.");

            return $this->redirectToRoute('profil_chien', ['id' => $profil->getId()]);
        }

        return $this->render('chiens/edit.html.twig',
                             ['form' => $form->createView(), 'chien' => $ch],

        );
    }

    /**
     * @Route("/profil_chien/{id}/suppression", name="delete_profil_chien", methods={"POST", "GET"})
     *
     */
    public function deleteChien(Chien $chien, Request $request): Response
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $usrRepo = $em->getRepository(Chien::class);
        $em->remove($chien);
        $em->flush();

        $this->addFlash('success', "La suppression a bien été prise en compte.");

        return $this->redirectToRoute('chiens');

    }
}