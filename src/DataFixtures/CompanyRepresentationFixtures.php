<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\CompanyFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\CompanyRepresentation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CompanyRepresentationFixtures extends Fixture implements DependentFixtureInterface
{
    public const CONTRACTOR_BANK_ACCOUNT_REFERENCE = 'contractor-bank-account';

    public function load(ObjectManager $manager)
    {
        $representation = new CompanyRepresentation();
        $representation->setCompany($this->getReference(CompanyFixtures::COMPANY_REFERENCE));
        $representation->setCompanyUser($this->getReference(UserFixtures::REPRESENTATION_USER_REFERENCE));
        $representation->setPosition('CEO');


        $manager->persist($representation);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
            UserFixtures::class
        ];
    }
}
