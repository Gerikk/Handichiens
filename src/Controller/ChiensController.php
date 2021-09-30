<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Chien;
use App\Form\NewChienType;
use Symfony\Component\String\Slugger\SluggerInterface;



class ChiensController extends AbstractController
{
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
}