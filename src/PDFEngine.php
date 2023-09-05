<?php

namespace ResumeCraft;

use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Mpdf\Output\Destination;

class PDFEngine
{
    private Mpdf $mpdf;
    const PROJECT_ROOT = __DIR__ . '/..'; // Define the constant for the root directory

    /**
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
    }

    /**
     * @param $metadata
     * @param $htmlContent
     * @return void
     * @throws MpdfException
     */
    public function __invoke($metadata, $htmlContent)
    {
        // Load CSS stylesheet and resume data from JSON file
        $stylesheet = file_get_contents(self::PROJECT_ROOT . '/resources/css/style.css');


        // Set metadata for the PDF document
        $this->mpdf->setTitle($metadata['pdfTitle']);
        $this->mpdf->setAuthor($metadata['pdfAuthor']);
        $this->mpdf->setCreator($metadata['pdfCreator']);
        $this->mpdf->setSubject($metadata['pdfSubject']);
        $this->mpdf->setKeywords($metadata['pdfKeywords']);

        // Write HTML content to the PDF
        $this->mpdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
        $this->mpdf->WriteHTML($htmlContent, HTMLParserMode::HTML_BODY);

        // Output the generated PDF
        $this->mpdf->Output('resumecraft.pdf', Destination::INLINE);
    }
}