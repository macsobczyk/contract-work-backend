<?php

namespace App\Repository;

use App\Entity\ContractMeta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContractMeta>
 *
 * @method ContractMeta|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractMeta|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractMeta[]    findAll()
 * @method ContractMeta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractMetaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractMeta::class);
    }

    //    /**
    //     * @return ContractMeta[] Returns an array of ContractMeta objects
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

    //    public function findOneBySomeField($value): ?ContractMeta
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
