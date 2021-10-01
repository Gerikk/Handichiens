<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Chien;
use App\Form\NewChienType;
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

    /**
     * @Route("/profil_chien/{id}/edit", name="edit_profil_chien")
     */
    public function edit(Chien $profil, Request $request): Response {
        $form = $this->createForm(NewChienType::class, $profil);
        $id = $request->get('id');
        $ch = $this->entityManager->getRepository(Chien::class)->findById($id);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
