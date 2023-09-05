<?php

require_once '../vendor/autoload.php'; // Load Composer's autoloader

use ResumeCraft\ResumePDFGenerator;
use ResumeCraft\Services\TemplateEngine;
use Spatie\Ignition\Ignition;

Ignition::make()->register();
const PROJECT_ROOT = __DIR__ . '/..';

$generator = new ResumePDFGenerator(new TemplateEngine());
$dataFile = '../data.json';

$generator->generatePDF($dataFile);