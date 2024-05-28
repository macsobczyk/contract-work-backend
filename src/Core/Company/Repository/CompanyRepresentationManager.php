<?php 

namespace App\Core\Company\Repository;

use App\Core\Company\Repository\CompanyRepresentationRepositoryInterface;

class CompanyRepresentationManager
{
    public function __construct(
        private CompanyRepresentationRepositoryInterface $repository
    )
    {
    }

    public function getRepository(): CompanyRepresentationRepositoryInterface
    {
        return $this->repository;
    }
}