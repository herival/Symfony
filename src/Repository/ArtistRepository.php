<?php

namespace App\Repository;

use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Artist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artist[]    findAll()
 * @method Artist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    /**
     * @return Artist[] Returns an array of Artist objects
     */
    
    public function findByName($recherche)
    {
        // SELECT a.* FROM artist WHERE name = "% . $recherche . %"
        return $this->createQueryBuilder('a')
            ->andWhere('a.name LIKE :recherche') //:recherche comme dans PDO requete préparé
            ->setParameter('recherche', "%" . $recherche . "%")
            ->orderBy('a.name', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return Artist[] Returns an array of Artist objects
     */
    

    public function findArtist()
    {
        // SELECT a.* FROM artist ORDER BY RAND()
        return $this->createQueryBuilder('a')
            ->orderBy('RAND()')
            ->setMaxResults(9)
            ->getQuery()
            ->getResult()
        ;
    }
    



    // /**
    //  * @return Artist[] Returns an array of Artist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Artist
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
