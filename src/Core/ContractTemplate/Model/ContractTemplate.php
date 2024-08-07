<?php

namespace App\Core\ContractTemplate\Model;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\ContractTemplate\ViewContractTemplateAction;
use App\Controller\ContractTemplate\ViewBillTemplateAction;
use App\Core\Contract\Model\Contract;
use App\Core\User\Model\Role;
use App\Core\ContractTemplate\Repository\ContractTemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Intl\Languages;
use \RuntimeException;

#[ORM\Entity(repositoryClass: ContractTemplateRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/contract/template/{id}',
            name: 'contract-template-view',
            requirements: ['id' => '\d+'],
            security: "is_granted('" . Role::ROLE_ADMIN . "')",
            normalizationContext: ['groups' => ['contract-template-details']]
        ),
        new Get(
            uriTemplate: '/contract/template/{id}/contract',
            name: 'contract-template-contract',
            requirements: ['id' => '\d+'],
            security: "is_granted('" . Role::ROLE_ADMIN . "')",
            controller: ViewContractTemplateAction::class,
        ),
        new Get(
            uriTemplate: '/contract/template/{id}/bill',
            name: 'contract-template-bill',
            requirements: ['id' => '\d+'],
            security: "is_granted('" . Role::ROLE_ADMIN . "')",
            controller: ViewBillTemplateAction::class,
        ),
        new GetCollection(
            uriTemplate: '/contract/template',
            security: "is_granted('" . Role::ROLE_ADMIN . "')",
            normalizationContext: ['groups' => ['contract-template-list']]
        )
    ],
    normalizationContext: ['groups' => ['contract-template-list', 'contract-template-list-details']],
    denormalizationContext: ['groups' => ['contract-template-write']],
)]
class ContractTemplate {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['contract-template-list', 'contract-template-details'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contract-template-list', 'contract-template-details'])]
    private ?string $name = null;

    #[ORM\Column(length: 5)]
    #[Groups(['contract-template-list', 'contract-template-details'])]
    private ?string $languageCode = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contract-template-details'])]
    private ?string $contractTemplatePath = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contract-template-details'])]
    private ?string $billTemplatePath = null;

    #[ORM\OneToMany(mappedBy: 'contractTemplate', targetEntity: Contract::class)]
    private Collection $contracts;

    public function __construct() {
        $this->contracts = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = $name;

        return $this;
    }

    public function getLanguageCode(): ?string {
        return $this->languageCode;
    }

    public function setLanguageCode(string $languageCode): static {
        $this->languageCode = $languageCode;

        return $this;
    }

    public function getContractTemplatePath(): ?string {
        return $this->contractTemplatePath;
    }

    public function setContractTemplatePath(string $contractTemplatePath): static {
        $this->contractTemplatePath = $contractTemplatePath;

        return $this;
    }

    public function getBillTemplatePath(): ?string {
        return $this->billTemplatePath;
    }

    public function setBillTemplatePath(string $billTemplatePath): static {
        $this->billTemplatePath = $billTemplatePath;

        return $this;
    }

    /**
     * @return Collection<int, Contract>
     */
    public function getContracts(): Collection {
        return $this->contracts;
    }

    public function addContract(Contract $contract): static {
        if (!$this->contracts->contains($contract)) {
            $this->contracts->add($contract);
            $contract->setContractTemplate($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): static {
        if ($this->contracts->removeElement($contract) && $contract->getContractTemplate() === $this) {
            $contract->setContractTemplate(null);
        }
    }

return $this;
}

#[
Groups(['contract-template-list', 'contract-template-details'])]
    public function getLanguage(): ?string {
    try {
        return Languages::getName($this->languageCode);
    } catch (RuntimeException $e) {
        return null;
    }
}
}
