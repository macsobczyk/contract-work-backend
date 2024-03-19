<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompanyRepresentationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompanyRepresentationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['company-representation-list','company-representation-details']],
    denormalizationContext: ['groups' => ['company-representation-write']],
)]
class CompanyRepresentation
{
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
