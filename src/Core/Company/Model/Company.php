<?php

namespace App\Core\Company\Model;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Core\Address\Model\Address;
use App\Core\User\Model\Role;
use App\Core\Contract\Model\Contract;
use App\Filter as CustomFilter;
use App\Core\Company\Repository\CompanyManager;
use App\Security\Voter\CompanyVoter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompanyManager::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/company/{id}',
            requirements: ['id' => '\d+'],
            security: "is_granted('".Role::ROLE_ADMIN."') or is_granted('".CompanyVoter::COMPANY_GET."',object)",
            normalizationContext: ['groups' => ['company-details']]
        ),
        new GetCollection(
            uriTemplate: '/company',
            security: "is_granted('".Role::ROLE_ADMIN."') or is_granted('".Role::ROLE_REPRESENTATIVE."')",
            normalizationContext: ['groups' => ['company-list']]
        )
    ],
    normalizationContext: ['groups' => ['company-list','company-details']],
    denormalizationContext: ['groups' => ['company-write']],
)]
#[ApiFilter(CustomFilter\CompanyKeywordSearchFilter::class, properties: [Company::COMPANY_KEYWORD_SEARCH])]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'ASC', 'name' => 'ASC', 'shortname' => 'ASC'])]
class Company
{
    public const COMPANY_KEYWORD_SEARCH = 'company_keyword_search';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['address-list','address-details','company-list','company-details','user-details','company-representation-list','company-representation-details'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address-list','address-details','company-list','company-details','user-details','company-representation-list','company-representation-details'])]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    #[Groups(['address-list','address-details','company-list','company-details','user-details','company-representation-list','company-representation-details'])]
    private ?string $shortname = null;

    #[ORM\OneToOne(inversedBy: 'addressCompany', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['company-list','company-details','user-details','company-representation-list','company-representation-details'])]
    private ?Address $address = null;

    #[ORM\Column(length: 50)]
    #[Groups(['company-list','company-details','user-details'])]
    private ?string $vatin = null;

    #[ORM\Column(length: 255)]
    #[Groups(['company-details'])]
    private ?string $courtRegistry = null;

    #[ORM\Column(length: 30)]
    #[Groups(['company-details'])]
    private ?string $registryNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(['company-details'])]
    private ?string $initialCapital = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyRepresentation::class, orphanRemoval: true)]
    #[Groups(['company-details'])]
    private Collection $representatives;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Contract::class)]
    private Collection $contracts;

    #[ORM\Column(length: 255)]
    #[Groups(['company-details'])]
    private ?string $dpoEmailAddress = null;

    public function __construct()
    {
        $this->representatives = new ArrayCollection();
        $this->contracts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getShortname(): ?string
    {
        return $this->shortname;
    }

    public function setShortname(string $shortname): static
    {
        $this->shortname = $shortname;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getVatin(): ?string
    {
        return $this->vatin;
    }

    public function setVatin(string $vatin): static
    {
        $this->vatin = $vatin;

        return $this;
    }

    public function getCourtRegistry(): ?string
    {
        return $this->courtRegistry;
    }

    public function setCourtRegistry(string $courtRegistry): static
    {
        $this->courtRegistry = $courtRegistry;

        return $this;
    }

    public function getRegistryNumber(): ?string
    {
        return $this->registryNumber;
    }

    public function setRegistryNumber(string $registryNumber): static
    {
        $this->registryNumber = $registryNumber;

        return $this;
    }

    public function getInitialCapital(): ?string
    {
        return $this->initialCapital;
    }

    public function setInitialCapital(string $initialCapital): static
    {
        $this->initialCapital = $initialCapital;

        return $this;
    }

    /**
     * @return Collection<int, CompanyRepresentation>
     */
    public function getRepresentatives(): Collection
    {
        return $this->representatives;
    }

    public function addRepresentative(CompanyRepresentation $representative): static
    {
        if (!$this->representatives->contains($representative)) {
            $this->representatives->add($representative);
            $representative->setCompany($this);
        }

        return $this;
    }

    public function removeRepresentative(CompanyRepresentation $representative): static
    {
        if ($this->representatives->removeElement($representative) && $representative->getCompany() === $this) {
                $representative->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contract>
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contract $contract): static
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts->add($contract);
            $contract->setCompany($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): static
    {
        if ($this->contracts->removeElement($contract) && $contract->getCompany() === $this) {
                $contract->setCompany(null);
            }
        }

        return $this;
    }

    public function getDpoEmailAddress(): ?string
    {
        return $this->dpoEmailAddress;
    }

    public function setDpoEmailAddress(string $dpoEmailAddress): static
    {
        $this->dpoEmailAddress = $dpoEmailAddress;

        return $this;
    }
}
