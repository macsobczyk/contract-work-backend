<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Filter as CustomFilter;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('email')]
#[UniqueEntity('username')]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/user/{id}',
            requirements: ['id' => '\d+'],
            security: "is_granted('".Role::ROLE_ADMIN."') or (is_granted('".Role::ROLE_USER."') and object == user)",
            normalizationContext: ['groups' => ['user-details']]
        ),
        new GetCollection(
            uriTemplate: '/user',
            security: "is_granted('".Role::ROLE_USER."')",
            normalizationContext: ['groups' => ['user-list']]
        )
    ],
    normalizationContext: ['groups' => ['user-list','user-details']],
    denormalizationContext: ['groups' => ['user-write']],
)]
#[ApiFilter(CustomFilter\UserKeywordSearchFilter::class, properties: [User::USER_KEYWORD_SEARCH])]
#[ApiFilter(CustomFilter\UserRoleSearchFilter::class, properties: [User::USER_ROLE_SEARCH])]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'ASC', 'firstname' => 'ASC', 'lastname' => 'ASC'])]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    public const USER_KEYWORD_SEARCH = 'user_keyword_search';

    public const USER_ROLE_SEARCH = 'user_role_search';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['address-list','address-details','company-details','bank-account-list','bank-account-details','user-list','user-details'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address-list','address-details','company-details','bank-account-list','bank-account-details', 'user-list','user-details'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['company-details','user-details'])]
    private ?string $middlename = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address-list','address-details','company-details','bank-account-list','bank-account-details', 'user-list','user-details'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Groups(['user-details'])]
    private ?string $username = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['address-list','address-details','company-details','bank-account-list','bank-account-details', 'user-list','user-details'])]
    private ?string $emailAddress = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'jsonb', options: ['jsonb' => true])]
    #[Groups(['user-details'])]
    private array $roles = [];

    #[ORM\Column]
    #[Groups(['user-list','user-details'])]
    private ?\DateTimeImmutable $expiresAt = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['company-details','user-details'])]
    private ?string $pesel = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['user-details'])]
    private ?string $vatin = null;

    #[ORM\OneToOne(inversedBy: 'addressUser', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user-list','user-details'])]
    private ?Address $address = null;

    #[ORM\OneToMany(mappedBy: 'companyUser', targetEntity: CompanyRepresentation::class, orphanRemoval: true)]
    #[Groups(['user-details'])]
    private Collection $representedCompanies;

    #[ORM\OneToMany(mappedBy: 'accountOwner', targetEntity: BankAccount::class, orphanRemoval: true)]
    #[Groups(['user-details'])]
    private Collection $bankAccounts;

    #[ORM\OneToMany(mappedBy: 'representation', targetEntity: Contract::class)]
    private Collection $representedContracts;

    #[ORM\OneToMany(mappedBy: 'contractor', targetEntity: Contract::class)]
    private Collection $contracts;

    public function __construct()
    {
        $this->representedCompanies = new ArrayCollection();
        $this->bankAccounts = new ArrayCollection();
        $this->representedContracts = new ArrayCollection();
        $this->contracts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMiddlename(): ?string
    {
        return $this->middlename;
    }

    public function setMiddlename(?string $middlename): static
    {
        $this->middlename = $middlename;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): static
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTimeImmutable $expiresAt): static
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getPesel(): ?string
    {
        return $this->pesel;
    }

    public function setPesel(?string $pesel): static
    {
        $this->pesel = $pesel;

        return $this;
    }

    public function getVatin(): ?string
    {
        return $this->vatin;
    }

    public function setVatin(?string $vatin): static
    {
        $this->vatin = $vatin;

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

    /**
     * @return Collection<int, CompanyRepresentation>
     */
    public function getRepresentedCompanies(): Collection
    {
        return $this->representedCompanies;
    }

    public function addRepresentedCompany(CompanyRepresentation $representedCompany): static
    {
        if (!$this->representedCompanies->contains($representedCompany)) {
            $this->representedCompanies->add($representedCompany);
            $representedCompany->setCompanyUser($this);
        }

        return $this;
    }

    public function removeRepresentedCompany(CompanyRepresentation $representedCompany): static
    {
        if ($this->representedCompanies->removeElement($representedCompany)) {
            // set the owning side to null (unless already changed)
            if ($representedCompany->getCompanyUser() === $this) {
                $representedCompany->setCompanyUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BankAccount>
     */
    public function getBankAccounts(): Collection
    {
        return $this->bankAccounts;
    }

    public function addBankAccount(BankAccount $bankAccount): static
    {
        if (!$this->bankAccounts->contains($bankAccount)) {
            $this->bankAccounts->add($bankAccount);
            $bankAccount->setAccountOwner($this);
        }

        return $this;
    }

    public function removeBankAccount(BankAccount $bankAccount): static
    {
        if ($this->bankAccounts->removeElement($bankAccount)) {
            // set the owning side to null (unless already changed)
            if ($bankAccount->getAccountOwner() === $this) {
                $bankAccount->setAccountOwner(null);
            }
        }

        return $this;
    }

    public function eraseCredentials()
    {
        $this->password = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    /**
     * @return Collection<int, Contract>
     */
    public function getRepresentedContracts(): Collection
    {
        return $this->representedContracts;
    }

    public function addRepresentedContract(Contract $representedContract): static
    {
        if (!$this->representedContracts->contains($representedContract)) {
            $this->representedContracts->add($representedContract);
            $representedContract->setRepresentation($this);
        }

        return $this;
    }

    public function removeRepresentedContract(Contract $representedContract): static
    {
        if ($this->representedContracts->removeElement($representedContract)) {
            // set the owning side to null (unless already changed)
            if ($representedContract->getRepresentation() === $this) {
                $representedContract->setRepresentation(null);
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
            $contract->setContractor($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): static
    {
        if ($this->contracts->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getContractor() === $this) {
                $contract->setContractor(null);
            }
        }

        return $this;
    }
}
