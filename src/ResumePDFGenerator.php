<?php

namespace ResumeCraft;

use Mpdf\MpdfException;
use ResumeCraft\Services\PDFEngine;
use ResumeCraft\Services\TemplateEngine;

/**
 * Class ResumePDFGenerator
 * Generates a PDF resume from JSON data using Twig and mPDF.
 */
class ResumePDFGenerator
{
    private TemplateEngine $templateEngine;

    /**
     * @param TemplateEngine $templateEngine
     */
    public function __construct(TemplateEngine $templateEngine)
    {
        // Initialize Twig and PDF Engine
        $this->templateEngine = $templateEngine;
    }

    /**
     * Generates a PDF resume.
     *
     * @param string $dataFile Path to the JSON data file.
     * @throws MpdfException
     */
    public function generatePDF(string $dataFile): void
    {
        $resumeData = json_decode(file_get_contents($dataFile), true);

        $htmlContent = $this->generateHTMLContent($resumeData);

        $PDFEngine = new PDFEngine();
        $PDFEngine($this->getPDFMeta($resumeData), $htmlContent);

    }

    private function generateHTMLContent(array $resumeData): string
    {
        // Define an array of template names and their corresponding resume data keys
        $resumeDataKeys = array_values(
            str_replace('.twig', '', $this->templateEngine->getTemplateList())
        );

        $htmlContent = '';
        foreach ($resumeData as $dataKey => $dataValue) {
            if (in_array($dataKey, $resumeDataKeys)) {
                $htmlContent .= $this->templateEngine->twig()->render($dataKey . '.twig', [$dataKey => $dataValue]);
            }
        }

        return $htmlContent;
    }

    /**
     * @param $resumeData
     * @return array
     */
    private function getPDFMeta($resumeData): array
    {
        return [
            'pdfTitle' => $resumeData['config']['pdfTitle'],
            'pdfAuthor' => $resumeData['config']['pdfAuthor'],
            'pdfCreator' => $resumeData['config']['pdfCreator'],
            'pdfSubject' => $resumeData['config']['pdfSubject'],
            'pdfKeywords' => $resumeData['config']['pdfKeywords'],
        ];
    }
}
