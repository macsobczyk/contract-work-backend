<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\ContractTemplate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContractTemplateFixtures extends Fixture
{
    public const CONTRACT_TEMPLATE_PL = 'contract-template-pl';

    public const CONTRACT_TEMPLATE_EN = 'contract-template-en';

    public function load(ObjectManager $manager)
    {
        $contractTemplatePL = $this->createContractTemplate(
            'PL',
            'Contract for a work with transfer of copyright',
            'contract_pl.html.twig',
            'bill_pl.html.twig'
        );

        $manager->persist($contractTemplatePL);
        $this->addReference(self::CONTRACT_TEMPLATE_PL, $contractTemplatePL);

        $contractTemplateEN = $this->createContractTemplate(
            'EN',
            'Contract for a work with transfer of copyright',
            'contract_en.html.twig',
            'bill_en.html.twig'
        );

        $manager->persist($contractTemplateEN);
        $this->addReference(self::CONTRACT_TEMPLATE_EN, $contractTemplateEN);

        $manager->flush();
    }

    private function createContractTemplate(string $language, string $name, string $contractPath, string $billPath): ContractTemplate
    {
        $contractTemplate = new ContractTemplate();
        $contractTemplate->setLanguageCode($language);
        $contractTemplate->setName($name);
        $contractTemplate->setContractTemplatePath($contractPath);
        $contractTemplate->setBillTemplatePath($billPath);

        return $contractTemplate;
    }
}
