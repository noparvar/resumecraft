<?php

namespace ResumeCraft;

use Mpdf\MpdfException;
use Throwable;
use Twig\Error\SyntaxError;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;

/**
 * Class ResumePDFGenerator
 * Generates a PDF resume from JSON data using Twig and mPDF.
 */
class ResumePDFGenerator
{
    private TemplateEngine $templateEngine;

    /**
     * Constructor.
     * Initializes mPDF and Twig.
     * @throws MpdfException
     */
    public function __construct()
    {
        // Initialize Twig and PDF Engine
        $this->templateEngine = new TemplateEngine();
    }

    /**
     * Generates a PDF resume.
     *
     * @param string $dataFile Path to the JSON data file.
     */
    public function generatePDF(string $dataFile): void
    {
        try {
            $resumeFile = file_get_contents($dataFile);
            $resumeData = json_decode($resumeFile, true);

            // Define an array of template names and their corresponding resume data keys
            $resumeDataKeys = array_values(
                str_replace('.twig', '', $this->templateEngine->getTemplateList())
            );

            $htmlContent = '';
            foreach ($resumeData as $dataKey => $dataValue) {
                if (in_array($dataKey, $resumeDataKeys)) {
                    $templateHtml = $this->templateEngine->twig()->render($dataKey . '.twig', [$dataKey => $dataValue]);
                    $htmlContent .= $templateHtml;
                }
            }

            $PDFEngine = new PDFEngine();
            $PDFEngine($this->getPDFMeta($resumeData), $htmlContent);


        } catch (MpdfException $e) {
            echo "An error occurred while generating the PDF: " . $e->getMessage();
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            echo "An error occurred while rendering Twig template: " . $e->getMessage() . $e->getTraceAsString();
        } catch (Throwable $e) {
            echo "General Error: " . $e->getMessage();
        }
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
