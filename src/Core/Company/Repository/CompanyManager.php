<?php

namespace App\Core\Company\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
class CompanyManager
{
    public function __construct(
        private CompanyRepositoryInterface $repository
    )
    {
    }

    public function getRepository(): CompanyRepositoryInterface
    {
        return $this->repository;
    }
}