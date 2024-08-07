<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Core\Company\Model\CompanyRepresentation;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

final class CompanyRepresentationKeywordSearchFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if (!($resourceClass === CompanyRepresentation::class && $property === CompanyRepresentation::COMPANY_REPRESENTATION_KEYWORD_SEARCH)
            || !$this->isPropertyEnabled($property, $resourceClass)
        ) {
            return;
        }

        $parameterName = $queryNameGenerator->generateParameterName($property); // Generate a unique parameter name to avoid collisions with other filters
        $queryBuilder
            ->leftJoin('o.company', 'c1')
            ->leftJoin('o.companyUser', 'u1')
            ->andWhere(
                str_replace(
                    '{{ parameter_name }}',
                    $parameterName,
                    'o.position LIKE :{{ parameter_name }}
                    OR c1.name LIKE :{{ parameter_name }} OR c1.shortname LIKE :{{ parameter_name }} OR c1.vatin LIKE :{{ parameter_name }} OR c1.registryNumber LIKE :{{ parameter_name }}
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
                'description' => 'Filter using a keyword search on the company name, company short name, company VAT identification number, company registry number, user first name, user last name and user email address',
                'openapi' => [
                    'example' => 'Brown',
                    'allowReserved' => false,// if true, query parameters will be not percent-encoded
                    'allowEmptyValue' => true,
                    'explode' => false, // to be true, the type must be Type::BUILTIN_TYPE_ARRAY, ?product=blue,green will be ?product=blue&product=green
                ],
            ];
        }

        return $description;
    }
}
