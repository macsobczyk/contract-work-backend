<?php 

namespace App\Core\BankAccount\Model;

final class BankAccountManager 
{
    public function __construct(
        private BankAccountRepositoryInterface $repository
    ) {}

    public function getRepository(): BankAccountRepositoryInterface
    {
        return $this->repository;
    }
}