<?php

namespace App\Core\Company\Repository;

use App\Core\Company\Model\CompanyRepresentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyRepresentation>
 *
 * @method CompanyRepresentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyRepresentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyRepresentation[]    findAll()
 * @method CompanyRepresentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepresentationRepository extends ServiceEntityRepository implements CompanyRepresentationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyRepresentation::class);
    }
}
