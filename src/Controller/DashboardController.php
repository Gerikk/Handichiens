<?php

namespace App\Controller;

use App\Entity\Chien;
use App\Entity\User;
use App\Entity\Booking;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function findBooking(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Booking::class);

        $bookings = $repository->findBy(array(),array('id'=>'DESC'),3,0);
        $allbookings = $repository->findAll();
        $dogsplaced = $repository->findAll();

        $dogsrepository = $em->getRepository(Chien::class);
        $dogsfree = $dogsrepository->findAll();

        return $this->render('dashboard/index.html.twig', [
            'bookings' => $bookings,
            'dogsplaced' => $dogsplaced,
            'dogsfree' => $dogsfree,
            'allbookings' => $allbookings,
        ]);
    }
}
