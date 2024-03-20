<?php

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Address;
use App\Entity\Role;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class AddressExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    public function __construct(
        private Security $security,
    )
    {
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []): void
    {
        // $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if (Address::class !== $resourceClass || $this->security->isGranted(Role::ROLE_ADMIN) || null === $user = $this->security->getUser()) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->leftJoin(
            sprintf('%s.addressUser', $rootAlias),
            sprintf('%su', $rootAlias)
        );
        $queryBuilder->andWhere(sprintf('%su.id = :current_user', $rootAlias));
        $queryBuilder->setParameter('current_user', $user->getId());
    }
}
