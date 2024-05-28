<?php

declare(strict_types=1);

namespace App\Controller\ContractTemplate;

use App\Core\ContractTemplate\Model\ContractTemplate;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class ViewBillTemplateAction extends BaseViewAction
{

    private const TEMPLATE_FILE_NAME = 'bill-template-%s-%s.pdf';

    public function __invoke(Request $request, ContractTemplate $data) : Response
    {
        $this->_filePath = 'contract-template/'.$data->getBillTemplatePath();
        $this->_fileNamePattern = self::TEMPLATE_FILE_NAME;

        return $this->renderTemplate($request, $data);
    }
}
