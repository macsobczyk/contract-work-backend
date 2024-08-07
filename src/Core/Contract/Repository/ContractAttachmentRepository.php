<?php

namespace App\Core\Contract\Repository;

use App\Core\Contract\Model\ContractAttachment;
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
class ContractAttachmentRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ContractAttachment::class);
    }

}
