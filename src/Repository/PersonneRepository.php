<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Personne>
 *
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    // public function findOneByNomAndPrenom(string $nom, string $prenom)
    // {
    //     // Récupère EntityManager
    //     $entityManager = $this->getEntityManager();
    //     // Requête DQL (requête préparée pour éviter les injections sql)
    //     $query = $entityManager->createQuery(
    //         'SELECT p
    //         FROM App\Entity\Personne p
    //         WHERE p.nom = :nom
    //         and p.prenom = :prenom'
    //     )->setParameter('nom', $nom)->setParameter('prenom', $prenom);
    //     // Limite les résultats à 1 ou null
    //     $result = $query->setMaxResults(1)->getOneOrNullResult();
    //     return $result;
    // }

    public function findOneByNomAndPrenom(string $nom, string $prenom)
    {
        // Récupère EntityManager
        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->getConnection()->prepare(
            'SELECT *
            FROM personne
            WHERE nom = :nom
            and prenom = :prenom'
        );
        $result = $query->executeQuery([
            'nom' => $nom,
            'prenom' => $prenom
        ]);
        // Limite les résultats à 1 ou null
        return $result->fetchAllAssociative()[0];
    }

//    /**
//     * @return Personne[] Returns an array of Personne objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Personne
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
