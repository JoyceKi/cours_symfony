<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
    #[Route('/twig/{nom}/{prenom}', name: 'app_twig')]
    public function index(Request $request): Response
    {
        $params = $request->attributes->get('_route_params');
        return $this->render('twig/index.html.twig', [
            'controller_name' => implode(" ", $params),
        ]);
    }
}
