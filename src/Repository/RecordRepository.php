<?php

namespace App\Repository;

use App\Entity\Record;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Record|null find($id, $lockMode = null, $lockVersion = null)
 * @method Record|null findOneBy(array $criteria, array $orderBy = null)
 * @method Record[]    findAll()
 * @method Record[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Record::class);
    }

    // /**
    //  * @return Record[] Returns an array of Record objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    // SELECT * FROM record WHERE artist_id IN (SELECT id FROM artist WHERE id = $value)
    
    /**
     * @return Record[] Returns an array of Record objects
     */
    
    public function findByTitle($recherche)
    {
        // SELECT a.* FROM artist WHERE name = "% . $recherche . %"
        return $this->createQueryBuilder('r')
            ->andWhere('r.title LIKE :recherche') //:recherche comme dans PDO requete préparé
            ->setParameter('recherche', "%" . $recherche . "%")
            ->orderBy('r.title', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Record[] Returns an array of Record objects
     */
    
    public function findByDescription($recherche)
    {
        // SELECT a.* FROM artist WHERE name = "% . $recherche . %"
        return $this->createQueryBuilder('r')
            ->andWhere('r.description LIKE :recherche OR r.description LIKE :recherche') //:recherche comme dans PDO requete préparé
            ->setParameter('recherche', "%" . $recherche . "%")
            ->getQuery()
            ->getResult()
        ;
    }

     /**
     * @return Record[] Returns an array of Record objects
     */
    public function findRecord()
    {
        // SELECT a.* FROM artist WHERE name = "% . $recherche . %"
        return $this->createQueryBuilder('r')
            ->orderBy('r.releasedAt', 'DESC')
            ->setMaxResults(9)
            ->getQuery()
            ->getResult()
        ;
    }

}
