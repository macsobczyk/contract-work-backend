<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Core\BankAccount\Model\BankAccount;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

final class BankAccountKeywordSearchFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if (!($resourceClass === BankAccount::class && $property === BankAccount::BANK_ACCOUNT_KEYWORD_SEARCH)
            || !$this->isPropertyEnabled($property, $resourceClass)
        ) {
            return;
        }

        $parameterName = $queryNameGenerator->generateParameterName($property); // Generate a unique parameter name to avoid collisions with other filters
        $queryBuilder
            ->leftJoin('o.accountOwner', 'u1')
            ->andWhere(
                str_replace(
                    '{{ parameter_name }}',
                    $parameterName,
                    'o.name LIKE :{{ parameter_name }} OR o.swift LIKE :{{ parameter_name }} OR o.accountNumber LIKE :{{ parameter_name }} OR o.bankName LIKE :{{ parameter_name }}
                    OR u1.firstname LIKE :{{ parameter_name }} OR u1.lastname LIKE :{{ parameter_name }} OR u1.emailAddress LIKE :{{ parameter_name }}'
                )
            )
            ->setParameter($parameterName, '%'.$value.'%');
    }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }

        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description[$property] = [
                'property' => $property,
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
                'description' => 'Filter using a keyword search on the bank account name, bank account swift, bank account number, bank account bank name, company name, company short name, user first name, user last name, user email address',
                'openapi' => [
                    'example' => 'World Bank',
                    'allowReserved' => false,// if true, query parameters will be not percent-encoded
                    'allowEmptyValue' => true,
                    'explode' => false, // to be true, the type must be Type::BUILTIN_TYPE_ARRAY, ?product=blue,green will be ?product=blue&product=green
                ],
            ];
        }

        return $description;
    }
}
