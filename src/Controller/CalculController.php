<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CalculController extends AbstractController
{
    #[Route('/calcul', name: 'app_calcul')]
    public function index(): Response
    {
        return $this->render('calcul/index.html.twig', [
            'controller_name' => 'CalculController',
        ]);
    }

    #[Route('/calcul/{op}', name: 'app_calcul')]
    public function apply(Request $request, $op): Response
    {
        $var1 = $request->query->get('var1');
        $var2 = $request->query->get('var2');

        switch ($op) {
            case 'plus':
                $result = $var1 + $var2;
                $message = "$var1 + $var2 = $result";
                break;
            case 'moins':
                $result = $var1 - $var2;
                $message = "$var1 - $var2 = $result";
                break;
            case 'fois':
                $result = $var1 * $var2;
                $message = "$var1 x $var2 = $result";
                break;
            case 'div':
                if ($var1 == 0 || $var2 == 0)
                {
                    $message = "$var1 / $var2 = Infinity";
                } else
                {
                    $result = $var1 / $var2;
                    $message = "$var1 / $var2 = $result";
                }
                break;
            
            default:
                    $message = "Erreur : opération non reconnue";
                    return $this->render('calcul/error.html.twig', [
                        'error_message' => $message,
                    ]);               
        }
      
        return $this->render('calcul/index.html.twig', [
            'controller_name' => $message,]);
    }
}
