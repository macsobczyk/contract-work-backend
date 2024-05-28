<?php

namespace App\Core\BankAccount\Model;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Core\BankAccount\Repository\BankAccountManager;
use App\Core\Contract\Model\Contract;
use App\Core\User\Model\Role;
use App\Core\User\Model\User;
use App\Filter as CustomFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BankAccountManager::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/bank-account/{id}',
            requirements: ['id' => '\d+'],
            security: "is_granted('".Role::ROLE_ADMIN."') or (is_granted('".Role::ROLE_USER."') and object.getAccountOwner() == user)",
            normalizationContext: ['groups' => ['bank-account-details']]
        ),
        new GetCollection(
            uriTemplate: '/bank-account',
            normalizationContext: ['groups' => ['bank-account-list']]
        )
    ],
    normalizationContext: ['groups' => ['bank-account-list','bank-account-details']],
    denormalizationContext: ['groups' => ['bank-account-write']],
)]
#[ApiFilter(CustomFilter\BankAccountKeywordSearchFilter::class, properties: [BankAccount::BANK_ACCOUNT_KEYWORD_SEARCH])]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'ASC', 'name' => 'ASC', 'accountNumber' => 'ASC', 'bankName' => 'ASC'])]
class BankAccount
{
    public const BANK_ACCOUNT_KEYWORD_SEARCH = 'bank_account_keyword_search';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['bank-account-list','bank-account-details','user-details'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bankAccounts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['bank-account-list','bank-account-details'])]
    private ?User $accountOwner = null;

    #[ORM\Column(length: 255)]
    #[Groups(['bank-account-list','bank-account-details','user-details'])]
    private ?string $name = null;

    #[ORM\Column(length: 12)]
    #[Groups(['bank-account-list','bank-account-details','user-details'])]
    private ?string $swift = null;

    #[ORM\Column(length: 255)]
    #[Groups(['bank-account-list','bank-account-details','user-details'])]
    private ?string $accountNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(['bank-account-list','bank-account-details','user-details'])]
    private ?string $bankName = null;

    #[ORM\OneToMany(mappedBy: 'contractorBankAccount', targetEntity: Contract::class)]
    private Collection $contracts;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountOwner(): ?User
    {
        return $this->accountOwner;
    }

    public function setAccountOwner(?User $accountOwner): static
    {
        $this->accountOwner = $accountOwner;

        return $this;
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

    public function getSwift(): ?string
    {
        return $this->swift;
    }

    public function setSwift(string $swift): static
    {
        $this->swift = $swift;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): static
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    public function setBankName(string $bankName): static
    {
        $this->bankName = $bankName;

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
            $contract->setContractorBankAccount($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): static
    {
        if ($this->contracts->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getContractorBankAccount() === $this) {
                $contract->setContractorBankAccount(null);
            }
        }

        return $this;
    }
}
