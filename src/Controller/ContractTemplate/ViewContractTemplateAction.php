<?php

declare(strict_types=1);

namespace App\Controller\ContractTemplate;

use App\Core\ContractTemplate\Model\ContractTemplate;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class ViewContractTemplateAction extends BaseViewAction
{

    private const TEMPLATE_FILE_NAME = 'contract-template-%s-%s.pdf';

    private const TEMPLATE_DIR = 'contract-template/';


    public function generateBillTemplate(ContractTemplate $data): void
    {
        $this->_filePath = self::TEMPLATE_DIR.$data->getBillTemplatePath();
        $this->_fileNamePattern = self::TEMPLATE_FILE_NAME;
    }

    public function generateContractTemplate(ContractTemplate $data): void
    {
        $this->_filePath = self::TEMPLATE_DIR.$data->getContractTemplatePath();
        $this->_fileNamePattern = self::TEMPLATE_FILE_NAME;
    }

    public function __invoke(Request $request, ContractTemplate $data) : Response
    {
        $this->_fileNamePattern = self::TEMPLATE_FILE_NAME;
        $this->_filePath = self::TEMPLATE_DIR.$data->getContractTemplatePath();

        return $this->renderTemplate($request, $data);
    }
}
