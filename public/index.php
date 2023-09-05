<?php

require_once '../vendor/autoload.php'; // Load Composer's autoloader

use ResumeCraft\ResumePDFGenerator;
use ResumeCraft\Services\PDFEngine;
use ResumeCraft\Services\TemplateEngine;
use ResumeCraft\Services\TwigTemplateEngine;
use Spatie\Ignition\Ignition;

Ignition::make()->register();
const PROJECT_ROOT = __DIR__ . '/..';

$generator = new ResumePDFGenerator(
    new TemplateEngine(new TwigTemplateEngine()), //load the template engine with twig Adapter
    new PDFEngine()
);

$dataFile = '../data.json';

$generator->generatePDF($dataFile);