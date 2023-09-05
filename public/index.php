<?php

require_once '../vendor/autoload.php'; // Load Composer's autoloader

use ResumeCraft\ResumePDFGenerator;
use ResumeCraft\Services\PDFEngines\PDFEngine;
use ResumeCraft\Services\TemplateEngines\TemplateEngine;
use ResumeCraft\Services\TemplateEngines\Twig\TwigTemplateEngine;
use Spatie\Ignition\Ignition;

Ignition::make()->register();
const PROJECT_ROOT = __DIR__ . '/..';

$generator = new ResumePDFGenerator(
    new TemplateEngine(new TwigTemplateEngine()), //load the template engine with twig Adapter
    new PDFEngine()
);

$dataFile = '../data.json';

$generator->generatePDF($dataFile);