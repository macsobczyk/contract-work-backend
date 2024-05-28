<?php

namespace App\Repository;

use App\Entity\ContractAttachment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContractAttachment>
 *
 * @method ContractAttachment|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractAttachment|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractAttachment[]    findAll()
 * @method ContractAttachment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractAttachmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractAttachment::class);
    }

    //    /**
    //     * @return ContractAttachment[] Returns an array of ContractAttachment objects
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

    //    public function findOneBySomeField($value): ?ContractAttachment
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
