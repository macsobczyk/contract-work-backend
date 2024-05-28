<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Core\Address\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture
{
    public const COMPANY_ADDRESS_REFERENCE = 'company-address';

    public const ADMIN_ADDRESS_REFERENCE = 'admin-address';

    public const CONTRACTOR1_ADDRESS_REFERENCE = 'contractor1-address';

    public const CONTRACTOR2_ADDRESS_REFERENCE = 'contractor2-address';

    public const CONTRACTOR3_ADDRESS_REFERENCE = 'contractor3-address';

    public const REPRESENTATION_ADDRESS_REFERENCE = 'representation-address';

    public function load(ObjectManager $manager)
    {
        $companyAddress = $this->createAddress(
            'Dummy Company Address',
            'Richardson Street 123',
            '12-345',
            'Warszawa',
            'PL',
            '123456789'
        );
        $manager->persist($companyAddress);
        $this->addReference(self::COMPANY_ADDRESS_REFERENCE, $companyAddress);

        $adminAddress = $this->createAddress(
            'Admin Address',
            'Tennessee Avenue 456',
            '12-345',
            'Wroclaw',
            'PL',
            '123456789'
        );
        $manager->persist($adminAddress);
        $this->addReference(self::ADMIN_ADDRESS_REFERENCE, $adminAddress);

        $contractorAddress1 = $this->createAddress(
            'Mark Johnson Address',
            'Shadow Street 321',
            '54-321',
            'Katowice',
            'PL',
            '987654321'
        );
        $manager->persist($contractorAddress1);
        $this->addReference(self::CONTRACTOR1_ADDRESS_REFERENCE, $contractorAddress1);

        $contractorAddress2 = $this->createAddress(
            'Luisa Spencer Address',
            'Holloway Street 321',
            '66-777',
            'Poznan',
            'PL',
            '917151311'
        );
        $manager->persist($contractorAddress2);
        $this->addReference(self::CONTRACTOR2_ADDRESS_REFERENCE, $contractorAddress2);

        $contractorAddress3 = $this->createAddress(
            'Peter Parker Address',
            'Ferry Street 321',
            '77-888',
            'Gdansk',
            'PL',
            '111151311'
        );
        $manager->persist($contractorAddress3);
        $this->addReference(self::CONTRACTOR3_ADDRESS_REFERENCE, $contractorAddress3);

        $representationAddress = $this->createAddress(
            'Dummy Representation Address',
            'Dummy Street 789',
            '67-890',
            'Dummy City',
            'PL',
            '123456789'
        );
        $manager->persist($representationAddress);
        $this->addReference(self::REPRESENTATION_ADDRESS_REFERENCE, $representationAddress);

        $manager->flush();
    }

    private function createAddress(string $name, string $address, string $postCode, string $city, string $countryCode, string $phoneNumber): Address
    {
        $addressEntity = new Address();
        $addressEntity->setName($name);
        $addressEntity->setAddress($address);
        $addressEntity->setPostCode($postCode);
        $addressEntity->setCity($city);
        $addressEntity->setCountryCode($countryCode);
        $addressEntity->setPhoneNumber($phoneNumber);

        return $addressEntity;
    }
}
