<?php

namespace App\Repository;

use App\Entity\OeuvreCompetition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OeuvreCompetition|null find($id, $lockMode = null, $lockVersion = null)
 * @method OeuvreCompetition|null findOneBy(array $criteria, array $orderBy = null)
 * @method OeuvreCompetition[]    findAll()
 * @method OeuvreCompetition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvreCompetitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OeuvreCompetition::class);
    }

    // /**
    //  * @return OeuvreCompetition[] Returns an array of OeuvreCompetition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OeuvreCompetition
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
