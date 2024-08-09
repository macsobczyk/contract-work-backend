<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Core\User\Model\Role;
use App\Core\User\Model\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface {
	public const ADMIN_USER_REFERENCE = 'admin-user';

	public const CONTRACTOR1_USER_REFERENCE = 'contractor1-user';

	public const CONTRACTOR2_USER_REFERENCE = 'contractor2-user';

	public const CONTRACTOR3_USER_REFERENCE = 'contractor3-user';

	public const REPRESENTATION_USER_REFERENCE = 'representation-user';

	private const PASSWORD = 'password';

	private const EXPIRES_AT = '+10 year';

	private const DEFAULT_PESEL = '12345678901';

	private const DEFAULT_VATIN = '1234567890';

	public function __construct(private UserPasswordHasherInterface $passwordEncoder) {
	}

	public function load(ObjectManager $manager) {
		$adminUser = $this->createUser(
			'John',
			'Alan',
			'Smith',
			'admin',
			new DateTimeImmutable(self::EXPIRES_AT),
			self::DEFAULT_PESEL,
			self::DEFAULT_VATIN,
			'admin@sentica.pl',
			self::PASSWORD,
			[Role::ROLE_ADMIN, Role::ROLE_USER]
		);
		$adminUser->setAddress($this->getReference(AddressFixtures::ADMIN_ADDRESS_REFERENCE));

		$manager->persist($adminUser);
		$this->addReference(self::ADMIN_USER_REFERENCE, $adminUser);

		$contractorUser1 = $this->createUser(
			'Mark',
			null,
			'Johnson',
			'contractor1',
			new DateTimeImmutable(self::EXPIRES_AT),
			self::DEFAULT_PESEL,
			self::DEFAULT_VATIN,
			'mark.johnson@sentica.pl',
			self::PASSWORD,
			[Role::ROLE_CONTRACTOR, Role::ROLE_USER]
		);
		$contractorUser1->setAddress($this->getReference(AddressFixtures::CONTRACTOR1_ADDRESS_REFERENCE));

		$manager->persist($contractorUser1);
		$this->addReference(self::CONTRACTOR1_USER_REFERENCE, $contractorUser1);

		$contractorUser2 = $this->createUser(
			'Luisa',
			'Hilda',
			'Spencer',
			'contractor2',
			new DateTimeImmutable(self::EXPIRES_AT),
			'99945678901',
			'9994567890',
			'luisa.spencer@sentica.pl',
			self::PASSWORD,
			[Role::ROLE_CONTRACTOR, Role::ROLE_USER]
		);
		$contractorUser2->setAddress($this->getReference(AddressFixtures::CONTRACTOR2_ADDRESS_REFERENCE));

		$manager->persist($contractorUser2);
		$this->addReference(self::CONTRACTOR2_USER_REFERENCE, $contractorUser2);

		$contractorUser3 = $this->createUser(
			'Peter',
			null,
			'Parker',
			'contractor3',
			new DateTimeImmutable(self::EXPIRES_AT),
			'10300678901',
			'1000560090',
			'peter.parker@sentica.pl',
			self::PASSWORD,
			[Role::ROLE_CONTRACTOR, Role::ROLE_USER]
		);
		$contractorUser3->setAddress($this->getReference(AddressFixtures::CONTRACTOR3_ADDRESS_REFERENCE));

		$manager->persist($contractorUser3);
		$this->addReference(self::CONTRACTOR3_USER_REFERENCE, $contractorUser3);

		$representationUser = $this->createUser(
			'Tom',
			'Andrew',
			'Brown',
			'representation',
			new DateTimeImmutable(self::EXPIRES_AT),
			self::DEFAULT_PESEL,
			self::DEFAULT_VATIN,
			'representation@sentica.pl',
			self::PASSWORD,
			[Role::ROLE_REPRESENTATIVE, Role::ROLE_USER]
		);
		$representationUser->setAddress($this->getReference(AddressFixtures::REPRESENTATION_ADDRESS_REFERENCE));

		$manager->persist($representationUser);
		$this->addReference(self::REPRESENTATION_USER_REFERENCE, $representationUser);

		$manager->flush();
	}

	private function createUser(string $firstName, ?string $middleName, string $lastName, string $username, DateTimeImmutable $expiresAt, string $pesel, string $vatin, string $emailAddress, string $password, array $roles): User {
		$user = new User();
		$user->setFirstname($firstName);
		$user->setMiddlename($middleName);
		$user->setLastname($lastName);
		$user->setUsername($username);
		$user->setExpiresAt($expiresAt);
		$user->setPesel($pesel);
		$user->setVatin($vatin);
		$user->setEmailAddress($emailAddress);
		$user->setPassword($this->passwordEncoder->hashPassword($user, $password));
		$user->setRoles($roles);

		return $user;
	}

	public function getDependencies() {
		return [
			AddressFixtures::class
		];
	}
}
