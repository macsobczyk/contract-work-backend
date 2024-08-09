<?php

namespace App\Core\Address\Model;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Core\Address\Repository\AddressManager;
use App\Core\Company\Model\Company;
use App\Core\User\Model\Role;
use App\Core\User\Model\User;
use App\Filter as CustomFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Intl\Countries;
use \RuntimeException;

#[ORM\Entity(repositoryClass: AddressManager::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/address/{id}',
            requirements: ['id' => '\d+'],
            security: "is_granted('".Role::ROLE_ADMIN."') or (is_granted('".Role::ROLE_USER."') and object.getAddressUser() == user)",
            normalizationContext: ['groups' => ['address-details']]
        ),
        new GetCollection(
            uriTemplate: '/address',
            normalizationContext: ['groups' => ['address-list']]
        ),
		new Post(
			uriTemplate: '/address',
			status: 301
		)
    ],
    normalizationContext: ['groups' => ['address-list','address-details']],
    denormalizationContext: ['groups' => ['address-write']],
)]
#[ApiFilter(
    SearchFilter::class, properties: [
        'addressCompany.id' => 'exact', 'countryCode' => 'exact',
        'addressUser.id' => 'exact'
    ]
)]
#[ApiFilter(CustomFilter\AddressKeywordSearchFilter::class, properties: [Address::ADDRESS_KEYWORD_SEARCH])]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'ASC', 'name' => 'DESC'])]
class Address
{
    public const ADDRESS_KEYWORD_SEARCH = 'address_keyword_search';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['address-list','address-details','company-details','user-list','user-details','company-representation-list','company-representation-details'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address-list','address-details','company-details','user-details'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address-list','address-details','company-list','company-details','user-details','company-representation-details'])]
    private ?string $address = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Groups(['address-list','address-details','company-list','company-details','user-details','company-representation-details'])]
    private ?string $postCode = null;

    #[ORM\Column(length: 50)]
    #[Groups(['address-list','address-details','company-list','company-details','user-list','user-details','company-representation-list','company-representation-details'])]
    private ?string $city = null;

    #[ORM\Column(length: 2)]
    #[Groups(['address-list','address-details','company-list','company-details','user-list','user-details','company-representation-list','company-representation-details'])]
    private ?string $countryCode = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['address-list','address-details','company-list','company-details','user-list','user-details','company-representation-details'])]
    private ?string $phoneNumber = null;

    #[ORM\OneToOne(mappedBy: 'address', cascade: ['persist', 'remove'])]
    #[Groups(['address-list','address-details'])]
    private ?Company $addressCompany = null;

    #[ORM\OneToOne(mappedBy: 'address', cascade: ['persist', 'remove'])]
    #[Groups(['address-list','address-details'])]
    private ?User $addressUser = null;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(?string $postCode): static
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): static
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAddressCompany(): ?Company
    {
        return $this->addressCompany;
    }

    public function setAddressCompany(Company $company): static
    {
        // set the owning side of the relation if necessary
        if ($company->getAddress() !== $this) {
            $company->setAddress($this);
        }

        $this->addressCompany = $company;

        return $this;
    }

    public function getAddressUser(): ?User
    {
        return $this->addressUser;
    }

    public function setAddressUser(User $addressUser): static
    {
        // set the owning side of the relation if necessary
        if ($addressUser->getAddress() !== $this) {
            $addressUser->setAddress($this);
        }

        $this->addressUser = $addressUser;

        return $this;
    }

    #[Groups(['address-list','address-details','company-list','user-list','user-details','company-representation-list','company-representation-details'])]
    public function getCountry(): ?string
    {
        try {
            return Countries::getName($this->countryCode);
        } catch(RuntimeException $e) {
            return null;
        }
    }

    #[Groups(['address-list','address-details','company-list','user-list','user-details','company-representation-list','company-representation-details'])]
    public function getAlpha3(): ?string
    {
        try {
            return Countries::getAlpha3Code($this->countryCode);
        } catch(RuntimeException $e) {
            return null;
        }
    }
}
