<?php

namespace App\Core\Company\Repository;

final class CompanyRepresentationManager
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