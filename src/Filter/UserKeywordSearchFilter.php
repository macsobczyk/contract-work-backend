<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Core\User\Model\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

final class UserKeywordSearchFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if (!($resourceClass === User::class && $property === User::USER_KEYWORD_SEARCH)
            || !$this->isPropertyEnabled($property, $resourceClass)
        ) {
            return;
        }

        $parameterName = $queryNameGenerator->generateParameterName($property); // Generate a unique parameter name to avoid collisions with other filters
        $queryBuilder
            ->leftJoin('o.address', 'a1')
            ->andWhere(
                str_replace(
                    '{{ parameter_name }}',
                    $parameterName,
                    'o.firstname LIKE :{{ parameter_name }} OR o.middlename LIKE :{{ parameter_name }} OR o.lastname LIKE :{{ parameter_name }}
                    OR o.emailAddress LIKE :{{ parameter_name }} OR o.pesel LIKE :{{ parameter_name }} OR o.vatin LIKE :{{ parameter_name }}
                    OR a1.name LIKE :{{ parameter_name }} OR a1.address LIKE :{{ parameter_name }} OR a1.postCode LIKE :{{ parameter_name }} OR a1.city LIKE :{{ parameter_name }}'
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
                'description' => 'Filter using a keyword search on the user name, user middle name, user last name, user email address, user PESEL, user VAT identification number, address name, address, post code and city',
                'openapi' => [
                    'example' => 'Parker',
                    'allowReserved' => false,// if true, query parameters will be not percent-encoded
                    'allowEmptyValue' => true,
                    'explode' => false, // to be true, the type must be Type::BUILTIN_TYPE_ARRAY, ?product=blue,green will be ?product=blue&product=green
                ],
            ];
        }

        return $description;
    }
}
