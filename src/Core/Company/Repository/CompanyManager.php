<?php 

namespace App\Core\Company\Repository;

use App\Core\Company\Repository\CompanyRepositoryInterface;

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