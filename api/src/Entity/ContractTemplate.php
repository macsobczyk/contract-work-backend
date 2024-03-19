<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ContractTemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractTemplateRepository::class)]
#[ApiResource]
class ContractTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 2)]
    private ?string $languageCode = null;

    #[ORM\Column(length: 255)]
    private ?string $contractTemplatePath = null;

    #[ORM\Column(length: 255)]
    private ?string $billTemplatePath = null;

    #[ORM\OneToMany(mappedBy: 'contractTemplate', targetEntity: Contract::class)]
    private Collection $contracts;

    public function __construct()
    {
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

    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }

    public function setLanguageCode(string $languageCode): static
    {
        $this->languageCode = $languageCode;

        return $this;
    }

    public function getContractTemplatePath(): ?string
    {
        return $this->contractTemplatePath;
    }

    public function setContractTemplatePath(string $contractTemplatePath): static
    {
        $this->contractTemplatePath = $contractTemplatePath;

        return $this;
    }

    public function getBillTemplatePath(): ?string
    {
        return $this->billTemplatePath;
    }

    public function setBillTemplatePath(string $billTemplatePath): static
    {
        $this->billTemplatePath = $billTemplatePath;

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
            $contract->setContractTemplate($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): static
    {
        if ($this->contracts->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getContractTemplate() === $this) {
                $contract->setContractTemplate(null);
            }
        }

        return $this;
    }
}
