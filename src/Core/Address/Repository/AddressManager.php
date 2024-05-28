<?php 

namespace App\Core\Address\Repository;

final class AddressManager 
{
    public function __construct(
        private AddressRepositoryInterface $repository
    ) {}

    public function getRepository(): AddressRepositoryInterface
    {
        return $this->repository;
    }
}