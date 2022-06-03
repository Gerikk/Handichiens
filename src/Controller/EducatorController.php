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

class EducatorController extends AbstractController
{
    /**
     * @Route("/educateur", name="educator_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $educateurs      = $userRepository->findByRole('ROLE_EDUCATEUR');
        $administrateurs = $userRepository->findByRole('ROLE_ADMIN');

        return $this->render('educator/index.html.twig', [
            'educateurs'      => $educateurs,
            'administrateurs' => $administrateurs
        ]);
    }

    /**
     * @Route("/educateur/{user}/promouvoir", name="educator_promote", methods={"GET"})
     */
    public function promoteToAdmin(User $user, EntityManagerInterface $_em): Response
    {
        if (in_array('ROLE_EDUCATEUR', $user->getRoles(), true)) {
            $user->setRoles(['ROLE_ADMIN']);

            $_em->persist($user);
            $_em->flush();

            $this->addFlash(
                'success',
                $user->getFirstname() . ' ' . $user->getLastname() . ' a été promu administrateur de l\'application !'
            );
        } else {
            $this->addFlash(
                'warning',
                'Cet utilisateur ne fait pas partie d\'Handi\'chiens; il ne peut pas être promu administrateur de l\'application !'
            );
        }

        return $this->redirectToRoute('educator_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/educateur/{user}/retrograder", name="educator_demote", methods={"GET"})
     */
    public function demoteFromAdmin(User $user, EntityManagerInterface $_em, UserRepository $userRepository): Response
    {
        $administrateurs = $userRepository->findByRole('ROLE_ADMIN');

        if (count($administrateurs) > 1) {
            $user->setRoles(['ROLE_EDUCATEUR']);

            $_em->persist($user);
            $_em->flush();

            $this->addFlash('success', $user->getFirstname() . ' ' . $user->getLastname() . ' n\'a plus le rôle administrateur !');
        } else {
            $this->addFlash('danger', 'Vous ne pouvez pas rétrograder cet administrateur, sans avoir donné les droits à un autre utilisateur');
        }

        return $this->redirectToRoute('educator_index', [], Response::HTTP_SEE_OTHER);
    }
}
