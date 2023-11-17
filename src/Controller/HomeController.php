<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Personne;


class HomeController extends AbstractController
{    
    #[Route('/home/', name: 'home_route')]
    public function index(): Response
    {
        $personne = new Personne();
        $personne->setNom("Doe");
        $personne->setPrenom("John");
        $tab = [2, 3, 8];
        return $this->render('home/index.html.twig', ['controller_name' => 'HomeController', 
        'tableau' => $tab, 
        'personne' => $personne]);
    }
}
