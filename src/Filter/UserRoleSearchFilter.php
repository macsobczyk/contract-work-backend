<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

/**
 * Role filter class for json fields
 */
final class UserRoleSearchFilter extends AbstractFilter
{
    /**
     * {@inheritdoc}
     */
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if (!$this->isPropertyEnabled($property, $resourceClass)
            || !($resourceClass === User::class and $property === User::USER_ROLE_SEARCH)
        ) {
            return;
        }

        $parameterName = $queryNameGenerator->generateParameterName('roles');

        $queryBuilder
            ->andWhere(sprintf("CONTAINS(o.%s, :%s) = true", 'roles', $parameterName))
            ->setParameter($parameterName, json_encode($value));
    }

    /**
     * {@inheritdoc}
     *
     * Hooks in documentation generators (supported by Swagger and Hydra)
     */
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
                'description' => 'Role exact name',
                'openapi' => [
                    'example' => 'ROLE_CONTRACTOR',
                    'allowReserved' => true,// if true, query parameters will be not percent-encoded
                    'allowEmptyValue' => true,
                    'explode' => true, // to be true, the type must be Type::BUILTIN_TYPE_ARRAY, ?product=blue,green will be ?product=blue&product=green
                ],
            ];
        }

        return $description;
    }
}
