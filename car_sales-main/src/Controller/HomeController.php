<?php

namespace App\Controller;

use App\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home_list")
     */
    public function index(): Response
    {
        $homes = $this->getDoctrine()
            ->getRepository(Car::class)
            ->findAll();
        return $this->render('home/index.html.twig', [
            'home' => $homes,
        ]);
    }


}
