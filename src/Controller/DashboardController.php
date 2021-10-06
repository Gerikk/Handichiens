<?php

namespace App\Controller;

use App\Entity\Chien;
use App\Entity\Booking;
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
        $allBookings = $repository->findAll();
        $dogsPlaced = $repository->findDogsPlaced();

        $dogsRepository = $em->getRepository(Chien::class);
        $dogsAll = $dogsRepository->findAll();

        return $this->render('dashboard/index.html.twig', [
            'bookings' => $bookings,
            'dogsplaced' => $dogsPlaced,
            'dogsAll' => $dogsAll,
            'allbookings' => $allBookings,
        ]);
    }
}
