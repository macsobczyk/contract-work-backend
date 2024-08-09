<?php

namespace App\Core\Company\Repository;

final class CompanyManager
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