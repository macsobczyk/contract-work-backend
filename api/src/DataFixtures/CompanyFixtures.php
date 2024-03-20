<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Company;
use App\DataFixtures\AddressFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
{
    public const COMPANY_REFERENCE = 'company';

    public function load(ObjectManager $manager)
    {
        $address = $this->getReference(AddressFixtures::COMPANY_ADDRESS_REFERENCE);

        $company = new Company();
        $company->setAddress($address);
        $company->setName('Dummy Company');
        $company->setShortname('DC');
        $company->setVatin('1234567890');
        $company->setCourtRegistry('Dummy Court Registry');
        $company->setRegistryNumber('1234567890');
        $company->setInitialCapital('1,000,000 PLN paid in full in cash');
        $company->setDpoEmailAddress('dpo@sentica.pl');

        $manager->persist($company);

        $this->addReference(self::COMPANY_REFERENCE, $company);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AddressFixtures::class,
        ];
    }
}
