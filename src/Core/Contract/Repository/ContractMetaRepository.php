<?php

namespace App\Core\Contract\Repository;

use App\Core\Contract\Model\ContractMeta;
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
class ContractMetaRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ContractMeta::class);
    }
}
