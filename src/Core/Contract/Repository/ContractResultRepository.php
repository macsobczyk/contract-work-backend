<?php

namespace App\Core\Contract\Repository;

use App\Core\Contract\Model\ContractResult;
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
class ContractResultRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ContractResult::class);
    }
}
