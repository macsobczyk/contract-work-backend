<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
#[ApiResource]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'representedContracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $representation = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $contractor = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BankAccount $contractorBankAccount = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ContractTemplate $contractTemplate = null;

    #[ORM\Column(length: 255)]
    private ?string $contractNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $issuedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $terminatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $paidAt = null;

    #[ORM\Column]
    private ?int $contractValueNet = null;

    #[ORM\Column]
    private ?int $contractValueGross = null;

    #[ORM\Column]
    private ?int $contractValueTax = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $results = null;

    #[ORM\Column]
    private ?bool $isPaid = null;

    #[ORM\Column]
    private ?bool $isTaxPaid = null;

    #[ORM\Column]
    private ?bool $isUndersigned = null;

    #[ORM\Column]
    private ?bool $isBooked = null;

    #[ORM\Column]
    private ?bool $isResultDelivered = null;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: ContractResult::class, orphanRemoval: true)]
    private Collection $resultFiles;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: ContractAttachment::class, orphanRemoval: true)]
    private Collection $attachments;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: ContractMeta::class, orphanRemoval: true)]
    private Collection $contractMeta;

    #[ORM\Column(length: 255)]
    private ?string $conclusionPlace = null;

    public function __construct()
    {
        $this->resultFiles = new ArrayCollection();
        $this->attachments = new ArrayCollection();
        $this->contractMeta = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRepresentation(): ?User
    {
        return $this->representation;
    }

    public function setRepresentation(?User $representation): static
    {
        $this->representation = $representation;

        return $this;
    }

    public function getContractor(): ?User
    {
        return $this->contractor;
    }

    public function setContractor(?User $contractor): static
    {
        $this->contractor = $contractor;

        return $this;
    }

    public function getContractorBankAccount(): ?BankAccount
    {
        return $this->contractorBankAccount;
    }

    public function setContractorBankAccount(?BankAccount $contractorBankAccount): static
    {
        $this->contractorBankAccount = $contractorBankAccount;

        return $this;
    }

    public function getContractTemplate(): ?ContractTemplate
    {
        return $this->contractTemplate;
    }

    public function setContractTemplate(?ContractTemplate $contractTemplate): static
    {
        $this->contractTemplate = $contractTemplate;

        return $this;
    }

    public function getContractNumber(): ?string
    {
        return $this->contractNumber;
    }

    public function setContractNumber(string $contractNumber): static
    {
        $this->contractNumber = $contractNumber;

        return $this;
    }

    public function getIssuedAt(): ?\DateTimeInterface
    {
        return $this->issuedAt;
    }

    public function setIssuedAt(\DateTimeInterface $issuedAt): static
    {
        $this->issuedAt = $issuedAt;

        return $this;
    }

    public function getTerminatedAt(): ?\DateTimeInterface
    {
        return $this->terminatedAt;
    }

    public function setTerminatedAt(?\DateTimeInterface $terminatedAt): static
    {
        $this->terminatedAt = $terminatedAt;

        return $this;
    }

    public function getPaidAt(): ?\DateTimeInterface
    {
        return $this->paidAt;
    }

    public function setPaidAt(?\DateTimeInterface $paidAt): static
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    public function getContractValueNet(): ?int
    {
        return $this->contractValueNet;
    }

    public function setContractValueNet(int $contractValueNet): static
    {
        $this->contractValueNet = $contractValueNet;

        return $this;
    }

    public function getContractValueGross(): ?int
    {
        return $this->contractValueGross;
    }

    public function setContractValueGross(int $contractValueGross): static
    {
        $this->contractValueGross = $contractValueGross;

        return $this;
    }

    public function getContractValueTax(): ?int
    {
        return $this->contractValueTax;
    }

    public function setContractValueTax(int $contractValueTax): static
    {
        $this->contractValueTax = $contractValueTax;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getResults(): ?string
    {
        return $this->results;
    }

    public function setResults(?string $results): static
    {
        $this->results = $results;

        return $this;
    }

    public function isIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): static
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function isIsTaxPaid(): ?bool
    {
        return $this->isTaxPaid;
    }

    public function setIsTaxPaid(bool $isTaxPaid): static
    {
        $this->isTaxPaid = $isTaxPaid;

        return $this;
    }

    public function isIsUndersigned(): ?bool
    {
        return $this->isUndersigned;
    }

    public function setIsUndersigned(bool $isUndersigned): static
    {
        $this->isUndersigned = $isUndersigned;

        return $this;
    }

    public function isIsBooked(): ?bool
    {
        return $this->isBooked;
    }

    public function setIsBooked(bool $isBooked): static
    {
        $this->isBooked = $isBooked;

        return $this;
    }

    public function isIsResultDelivered(): ?bool
    {
        return $this->isResultDelivered;
    }

    public function setIsResultDelivered(bool $isResultDelivered): static
    {
        $this->isResultDelivered = $isResultDelivered;

        return $this;
    }

    /**
     * @return Collection<int, ContractResult>
     */
    public function getResultFiles(): Collection
    {
        return $this->resultFiles;
    }

    public function addResultFile(ContractResult $resultFile): static
    {
        if (!$this->resultFiles->contains($resultFile)) {
            $this->resultFiles->add($resultFile);
            $resultFile->setContract($this);
        }

        return $this;
    }

    public function removeResultFile(ContractResult $resultFile): static
    {
        if ($this->resultFiles->removeElement($resultFile)) {
            // set the owning side to null (unless already changed)
            if ($resultFile->getContract() === $this) {
                $resultFile->setContract(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ContractAttachment>
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(ContractAttachment $attachment): static
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments->add($attachment);
            $attachment->setContract($this);
        }

        return $this;
    }

    public function removeAttachment(ContractAttachment $attachment): static
    {
        if ($this->attachments->removeElement($attachment)) {
            // set the owning side to null (unless already changed)
            if ($attachment->getContract() === $this) {
                $attachment->setContract(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ContractMeta>
     */
    public function getContractMeta(): Collection
    {
        return $this->contractMeta;
    }

    public function addContractMetum(ContractMeta $contractMetum): static
    {
        if (!$this->contractMeta->contains($contractMetum)) {
            $this->contractMeta->add($contractMetum);
            $contractMetum->setContract($this);
        }

        return $this;
    }

    public function removeContractMetum(ContractMeta $contractMetum): static
    {
        if ($this->contractMeta->removeElement($contractMetum)) {
            // set the owning side to null (unless already changed)
            if ($contractMetum->getContract() === $this) {
                $contractMetum->setContract(null);
            }
        }

        return $this;
    }

    public function getConclusionPlace(): ?string
    {
        return $this->conclusionPlace;
    }

    public function setConclusionPlace(string $conclusionPlace): static
    {
        $this->conclusionPlace = $conclusionPlace;

        return $this;
    }
}
