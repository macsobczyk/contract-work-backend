<?php

namespace App\Address\Model\Repository;

use App\Core\Address\Model\Address;
use App\Core\Address\Repository\AddressRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Address>
 *
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository implements AddressRepositoryInterface {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Address::class);
    }
}
