<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Filter as CustomFilter;
use App\Repository\CompanyRepresentationRepository;
use App\Security\Voter\CompanyRepresentationVoter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompanyRepresentationRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/representation/{id}',
            requirements: ['id' => '\d+'],
            security: "is_granted('".Role::ROLE_ADMIN."') or is_granted('".CompanyRepresentationVoter::COMPANY_REPRESENTATION_GET."',object)",
            normalizationContext: ['groups' => ['company-representation-details']]
        ),
        new GetCollection(
            uriTemplate: '/representation',
            security: "is_granted('".Role::ROLE_ADMIN."') or is_granted('".Role::ROLE_REPRESENTATIVE."')",
            normalizationContext: ['groups' => ['company-representation-list']]
        )
    ],
    normalizationContext: ['groups' => ['company-representation-list','company-representation-details']],
    denormalizationContext: ['groups' => ['company-representation-write']],
)]
#[ApiFilter(CustomFilter\CompanyRepresentationKeywordSearchFilter::class, properties: [CompanyRepresentation::COMPANY_REPRESENTATION_KEYWORD_SEARCH])]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'ASC', 'company.name' => 'ASC', 'position' => 'ASC'])]
class CompanyRepresentation
{
    public const COMPANY_REPRESENTATION_KEYWORD_SEARCH = 'company_representation_keyword_search';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['company-representation-list','company-representation-details','company-details','user-details'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'representedCompanies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['company-representation-list','company-representation-details','company-details'])]
    private ?User $companyUser = null;

    #[ORM\ManyToOne(inversedBy: 'representatives')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['company-representation-list','company-representation-details','user-details'])]
    private ?Company $company = null;

    #[ORM\Column(length: 255)]
    #[Groups(['company-representation-list','company-representation-details','company-details','user-details'])]
    private ?string $position = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyUser(): ?User
    {
        return $this->companyUser;
    }

    public function setCompanyUser(?User $companyUser): static
    {
        $this->companyUser = $companyUser;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }
}
