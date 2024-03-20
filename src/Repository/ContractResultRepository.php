<?php

namespace App\Repository;

use App\Entity\ContractResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContractResult>
 *
 * @method ContractResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractResult[]    findAll()
 * @method ContractResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractResult::class);
    }

    //    /**
    //     * @return ContractResult[] Returns an array of ContractResult objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ContractResult
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
