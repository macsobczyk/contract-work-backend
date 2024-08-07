<?php

namespace App\Core\ContractTemplate\Repository;

use App\Core\ContractTemplate\Model\ContractTemplate;
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
class ContractTemplateRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ContractTemplate::class);
    }
}
