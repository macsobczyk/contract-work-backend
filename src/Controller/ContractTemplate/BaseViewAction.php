<?php

declare(strict_types=1);

namespace App\Controller\ContractTemplate;

use App\Core\ContractTemplate\Model\ContractTemplate;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class BaseViewAction extends AbstractController
{

    protected string $_filePath = '';

    protected string $_fileNamePattern = '';

    public function __construct(
        private readonly Pdf $pdf,
    )
    {
    }

    public function renderTemplate(Request $request, ContractTemplate $data) : Response
    {
        $content = $this->renderView($this->_filePath, []);

        $pdfContent = $this->pdf->getOutputFromHtml($content, []);

        $fileName = sprintf($this->_fileNamePattern, $data->getId(), $data->getLanguageCode());

        $response = new Response($pdfContent);
        $response->headers->set('Content-type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $fileName));
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        return $response;
    }
}
