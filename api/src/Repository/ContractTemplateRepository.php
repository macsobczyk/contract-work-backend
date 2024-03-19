<?php

namespace App\Repository;

use App\Entity\ContractTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContractTemplate>
 *
 * @method ContractTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractTemplate[]    findAll()
 * @method ContractTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractTemplate::class);
    }

    //    /**
    //     * @return ContractTemplate[] Returns an array of ContractTemplate objects
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

    //    public function findOneBySomeField($value): ?ContractTemplate
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
