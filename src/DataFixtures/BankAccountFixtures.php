<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Core\BankAccount\Model\BankAccount;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BankAccountFixtures extends Fixture implements DependentFixtureInterface {
    public const CONTRACTOR_BANK_ACCOUNT_REFERENCE = 'contractor-bank-account';

    private const DEFAULT_BANK_NAME1 = 'PKO BP S.A.';

    private const DEFAULT_SWIFT1 = 'BPKOPLPW';

    private const DEFAULT_BANK_NAME2 = 'ALIOR Bank S.A.';

    private const DEFAULT_SWIFT2 = 'ALBPPLPW';

    public function load(ObjectManager $manager) {

        $contractor1BankAccount1 = $this->createBankAccount(
            'Mark Johnson main account',
            'PL12345678901234567890123456',
            self::DEFAULT_BANK_NAME1,
            self::DEFAULT_SWIFT1
        );
        $contractor1BankAccount1->setAccountOwner($this->getReference(UserFixtures::CONTRACTOR1_USER_REFERENCE));
        $manager->persist($contractor1BankAccount1);

        $contractor1BankAccount2 = $this->createBankAccount(
            'Mark Johnson additional account',
            'PL50345600901234567890123400',
            self::DEFAULT_BANK_NAME1,
            self::DEFAULT_SWIFT1
        );
        $contractor1BankAccount2->setAccountOwner($this->getReference(UserFixtures::CONTRACTOR1_USER_REFERENCE));
        $manager->persist($contractor1BankAccount2);

        $contractor2BankAccount1 = $this->createBankAccount(
            'Luisa Spencer main account',
            'PL12345678901234567890123456',
            self::DEFAULT_BANK_NAME1,
            self::DEFAULT_SWIFT1
        );
        $contractor2BankAccount1->setAccountOwner($this->getReference(UserFixtures::CONTRACTOR2_USER_REFERENCE));
        $manager->persist($contractor2BankAccount1);

        $contractor3BankAccount1 = $this->createBankAccount(
            'Peter Parker main account',
            'PL50345600901234567890123400',
            self::DEFAULT_BANK_NAME1,
            self::DEFAULT_SWIFT1
        );
        $contractor3BankAccount1->setAccountOwner($this->getReference(UserFixtures::CONTRACTOR3_USER_REFERENCE));
        $manager->persist($contractor3BankAccount1);

        $contractor3BankAccount2 = $this->createBankAccount(
            'Peter Parker additional account',
            'PL50345600901234567890123400',
            self::DEFAULT_BANK_NAME2,
            self::DEFAULT_SWIFT2
        );
        $contractor3BankAccount2->setAccountOwner($this->getReference(UserFixtures::CONTRACTOR3_USER_REFERENCE));
        $manager->persist($contractor3BankAccount1);

        $manager->flush();
    }

    private function createBankAccount(string $name, string $accountNumber, string $bankName, string $swift): BankAccount {
        $bankAccount = new BankAccount();
        $bankAccount->setName($name);
        $bankAccount->setAccountNumber($accountNumber);
        $bankAccount->setBankName($bankName);
        $bankAccount->setSwift($swift);

        return $bankAccount;
    }

    public function getDependencies() {
        return [
            UserFixtures::class
        ];
    }
}
