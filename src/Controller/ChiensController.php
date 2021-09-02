<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Chien;
use App\Form\NewChienType;

class ChiensController extends AbstractController
{
    /**
     * @Route("/chiens", name="chiens")
     */
    public function index(): Response
    {
        return $this->render('chiens/index.html.twig', [
            'controller_name' => 'ChiensController',
        ]);
    }

    /**
     * @Route("/chiens/ajouter", name="chiens_ajouter")
     */
    public function new(Request $request): Response
    {
        // just setup a fresh $task object (remove the example data)
        $task = new Chien();

        $form = $this->createForm(NewChienType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return new Response('Votre nouveau chien à bien été crée');
        }

        return $this->render('chiens/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
