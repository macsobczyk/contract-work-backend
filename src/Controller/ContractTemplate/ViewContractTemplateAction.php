<?php

declare(strict_types=1);

namespace App\Controller\ContractTemplate;

use App\Entity\ContractTemplate;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class ViewContractTemplateAction extends AbstractController
{

    private const FILE_NAME = 'contract-template-%s-%d.pdf';

    public function __construct(
        private readonly Pdf $pdf,
    )
    {
    }

    public function __invoke(Request $request, ContractTemplate $data) : Response
    {
        $content = $this->renderView(
            'contract-template/'.$data->getContractTemplatePath(),
            []
        );

        $pdfContent = $this->pdf->getOutputFromHtml(
            $content,
            []
        );

        $fileName = sprintf(self::FILE_NAME, $data->getId(), $data->getLanguageCode());

        $response = new Response($pdfContent);
        $response->headers->set('Content-type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $fileName));
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        return $response;
    }
}
