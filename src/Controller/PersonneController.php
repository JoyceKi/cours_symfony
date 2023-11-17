<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    #[Route('/personne/add', name: 'personne_add')]
    public function index(EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        // Vérifie si la personne existe déjà en bdd
        $existePersonne = $entityManager->getRepository(Personne::class)->findOneBy([
            'nom' => 'Dalton',
            'prenom' => 'Jack',
            'sexe' => 'm',
        ]);

        if ($existePersonne) {
            return $this->render('personne/index.html.twig', [
                'controller_name' => 'PersonneController',
                'personne' => $existePersonne,
                'adjectif' => 'existante',
            ]);
        }

        // si la personne n'est pas en bdd
        $personne = new Personne;
        $personne->setNom('Dalton');
        $personne->setPrenom('Jack');
        $personne->setSexe('m');
        $errors = $validator->validate($personne);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $entityManager->persist($personne);
        $entityManager->flush();
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'adjectif' => 'ajoutée'
        ]);
    }

    #[Route('/personne/show', name: 'personne_show_all', priority:1)]
    public function showAllPersonne(PersonneRepository $personneRepository)
    {
        $personnes = $personneRepository->findAll();
        if (!$personnes) {
            throw $this->createNotFoundException('La table est vide');
        }
        return $this->render('personne/show.html.twig', [
            'controller_name' => 'PersonneController',
            'personnes' => $personnes,
        ]);
    }

    // #[Route('/personne/{id}', name: 'personne_show', priority: 2)]
    // public function showPersonne(int $id, PersonneRepository $personneRepository)
    // {
    //     $personne = $personneRepository->find($id);
    //     if (!$personne) {
    //         throw $this->createNotFoundException(
    //             'Personne non trouvée avec l\'id' . $id
    //         );
    //     }
    //     return $this->render('personne/index.html.twig', [
    //         'controller_name' => 'PersonneController',
    //         'personne' => $personne,
    //         'adjectif' => 'recherchée'
    //     ]);
    // }

    #[Route('/personne/{nom}/{prenom}', name: 'personne_show_one', priority: 3)]
    public function showPersonneByNomAndPrenom(
        string $nom,
        string $prenom,
        PersonneRepository $personneRepository
    ) {
        $personne = $personneRepository->findOneBy([
            "nom" => $nom,
            "prenom" => $prenom
        ]);
        if (!$personne) {
            throw $this->createNotFoundException('Personne non trouvée');
        }
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'adjectif' => 'recherchée'
        ]);
    }
}
