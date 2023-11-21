<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Personne;
use App\Entity\Sport;
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
        // // Vérifie si la personne existe déjà en bdd
        // $existePersonne = $entityManager->getRepository(Personne::class)->findOneBy([
        //     'nom' => 'Kobain',
        //     'prenom' => 'Kurt',
        //     'sexe' => 'm',
        // ]);

        // if ($existePersonne) {
        //     return $this->render('personne/index.html.twig', [
        //         'controller_name' => 'PersonneController',
        //         'personne' => $existePersonne,
        //         'adjectif' => 'existante',
        //     ]);
        // }

        // si la personne n'est pas en bdd
        // $adresse = new Adresse();
        // $adresse->setRue('Venture');
        // $adresse->setVille('Lille');
        // $adresse->setCodePostal(59000);
        // // 1ère personne
        // $personne = new Personne;
        // $personne->setNom('Faust');
        // $personne->setPrenom('Laure');
        // $personne->setSexe('f');
        // $personne->setAdresse($adresse);
        // // 2ème personne
        // $personne2 = new Personne;
        // $personne2->setNom('Aubry');
        // $personne2->setPrenom('Daniel');
        // $personne2->setSexe('m');
        // $personne2->setAdresse($adresse);
        // // persistance des données
        // $entityManager->persist($personne);
        // $entityManager->persist($personne2);
        // $errors = $validator->validate($personne);
        // if (count($errors) > 0) {
        //     return new Response((string) $errors, 400);
        // }

        // $entityManager->flush();
        // return $this->render('personne/index.html.twig', [
        //     'controller_name' => 'PersonneController',
        //     'personne' => $personne,
        //     'adjectif' => 'ajoutée(s)'
        // ]);

        $sport = new Sport();
        $sport->setName('Football');

        $sport2 = new Sport();
        $sport2->setName('Tennis');
        // 1ère personne
        $personne = new Personne();
        $personne->setNom('Swift');
        $personne->setPrenom('Taylor');
        $personne->setSexe('f');
        $personne->addSport($sport);
        $personne->addSport($sport2);
        // 2ème personne
        $personne2 = new Personne();
        $personne2->setNom('Smith');
        $personne2->setPrenom('Dany');
        $personne2->setSexe('m');
        $personne2->addSport($sport);

        $entityManager->persist($personne);
        $entityManager->persist($personne2);
        $entityManager->flush();

        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne, $personne2,
            'adjectif' => 'ajoutée(s)'
            ]);

    }

    #[Route('/personne/show', name: 'personne_show_all', priority: 1)]
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
        $personne = $personneRepository->findOneByNomAndPrenom($nom, $prenom);
        if (!$personne) {
            throw $this->createNotFoundException('Personne non trouvée');
        }
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'adjectif' => 'recherchée'
        ]);
    }

    // #[Route('/personne/edit/{id}', name: 'personne_update')]
    // public function updatePersonne(int $id, EntityManagerInterface $entityManager)
    // {
    //     $personne = $entityManager->getRepository(Personne::class)->find($id);
    //     if (!$personne) {
    //         throw $this->createNotFoundException('Personne non trouvée avec l\'id' . $id);
    //     }
    //     $personne->setNom('Travolta');
    //     $entityManager->flush();
    //     return $this->render('personne/index.html.twig', [
    //         'controller_name' => 'PersonneController',
    //         'personne' => $personne,
    //         'adjectif' => 'modifiée'
    //     ]);
    // }

    #[Route('/personne/edit/{id}', name: 'personne_update')]
    public function updatePersonne(EntityManagerInterface $entityManager, Personne $personne)
    {
        if (!$personne) {
            throw $this->createNotFoundException(
                'Personne non trouvée avec l\'id' . $personne->$personne->getId());
        }
        $personne->setNom('Abruzzi');
        $entityManager->flush();
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'personne' => $personne,
            'adjectif' => 'modifiée'
        ]);
    }

    // #[Route('/personne/delete/{id}', name: 'peronne_delete')]
    // public function deletePersonne(int $id, EntityManagerInterface $entityManager)
    // {
    //     $personne = $entityManager->getRepository(Personne::class)->find($id);
    //     if (!$personne) {
    //         throw $this->createNotFoundException(
    //             'Personne non trouvée avec l\'id' . $id
    //         );
    //     }
    //     $entityManager->remove($personne);
    //     $entityManager->flush();
    //     return $this->redirectToRoute("personne_show_all");
    // }
    #[Route('/personne/delete/{id}', name: 'peronne_delete')]
    public function deletePersonne(Personne $personne, EntityManagerInterface $entityManager)
    {
        if (!$personne) {
            throw $this->createNotFoundException(
                'Personne non trouvée avec l\'id' . $personne->getId()
            );
        }
        $entityManager->remove($personne);
        $entityManager->flush();
        return $this->redirectToRoute("personne_show_all");
    }

    #[Route('/personne/show/{nom}/{prenom}/{number}', name: 'personne_shpw_some')]
    public function showSomePersonne(string $nom, string $prenom, int $number, PersonneRepository 
    $personneRepository)
    {
        dump($number);
        $personnes = $personneRepository->findBy(
            [
                "nom" => $nom,
                "prenom" => $prenom,
                "id" => $number
            ],
            ["nom" => "ASC"],
        );
        if (!$personnes) {
            throw $this->createNotFoundException('Aucun résultat trouvé');
        }
        return $this->render('personne/show.html.twig', [
            'controller_name' => 'PersonneController',
            'personnes' => $personnes,
        ]);
    }

}
