<?php

namespace ResumeCraft;

use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Mpdf\HTMLParserMode;
use Mpdf\Config\FontVariables;
use Mpdf\Config\ConfigVariables;
use Twig\Environment;
use Twig\Error\SyntaxError;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Loader\FilesystemLoader;

/**
 * Class ResumePDFGenerator
 * Generates a PDF resume from JSON data using Twig and mPDF.
 */
class ResumePDFGenerator
{
    private Mpdf $mpdf;
    private Environment $twig;
    const PROJECT_ROOT = __DIR__ . '/..'; // Define the constant for the root directory

    /**
     * Constructor.
     * Initializes mPDF and Twig.
     * @throws MpdfException
     */
    public function __construct()
    {
        // Initialize Mpdf with custom configurations
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $this->mpdf = new Mpdf([
            'tempDir' => self::PROJECT_ROOT . '/cache/',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,
            'fontDir' => array_merge($fontDirs, [
                self::PROJECT_ROOT . '/resources/fonts/',
            ]),
            'fontdata' => $fontData + [
                    'nunito' => [
                        'R' => 'NunitoSans-Regular.ttf',
                        'I' => 'NunitoSans-ExpandedBlack.ttf',
                        'B' => 'NunitoSans-ExtraBold.ttf',
                        'BI' => 'NunitoSans-ExtraBoldItalic.ttf'
                    ],
                    'customicons' => [
                        'R' => 'CustomIconsForResume.ttf'
                    ]
                ],
            'default_font' => 'nunito'
        ]);

        // Initialize Twig for template rendering
        $loader = new FilesystemLoader(self::PROJECT_ROOT . '/resources/templates');
        $this->twig = new Environment($loader, [
            'cache' => false, // Set to '../cache/' if you want to use cache
        ]);
    }

    /**
     * Generates a PDF resume.
     *
     * @param string $dataFile Path to the JSON data file.
     */
    public function generatePDF(string $dataFile): void
    {
        try {
            // Load CSS stylesheet and resume data from JSON file
            $stylesheet = file_get_contents(self::PROJECT_ROOT . '/resources/css/style.css');
            $resumeFile = file_get_contents($dataFile);
            $resumeData = json_decode($resumeFile, true);

            // Set metadata for the PDF document
            $this->mpdf->setTitle($resumeData['config']['pdfTitle']);
            $this->mpdf->setAuthor($resumeData['config']['pdfAuthor']);
            $this->mpdf->setCreator($resumeData['config']['pdfCreator']);
            $this->mpdf->setSubject($resumeData['config']['pdfSubject']);
            $this->mpdf->setKeywords($resumeData['config']['pdfKeywords']);

            // Define an array of template names and their corresponding resume data keys
            $templateDataMap = [
                'personalInformation.twig' => 'personalInfo',
                'workExperiences.twig' => 'experiences',
                'educations.twig' => 'educations',
                'skills.twig' => 'skills',
                'awards.twig' => 'awards',
                'languages.twig' => 'languages',
            ];

            $htmlContent = '';

            // Render different sections of the resume using Twig templates
            foreach ($templateDataMap as $templateName => $dataKey) {
                $templateHtml = $this->twig->render($templateName, [$dataKey => $resumeData[$dataKey]]);
                $htmlContent .= $templateHtml;
            }

            // Write HTML content to the PDF
            $this->mpdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
            $this->mpdf->WriteHTML($htmlContent, HTMLParserMode::HTML_BODY);


            // Output the generated PDF
            $this->mpdf->Output();
        } catch (MpdfException $e) {
            echo "An error occurred while generating the PDF: " . $e->getMessage();
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            echo "An error occurred while rendering Twig template: " . $e->getMessage();
        }
    }
}
