<?php

require_once '../vendor/autoload.php'; // Load Composer's autoloader

use ResumeCraft\ResumePDFGenerator;
use Spatie\Ignition\Ignition;

$generator = new ResumePDFGenerator();
$dataFile = '../data.json';

Ignition::make()->register();
$generator->generatePDF($dataFile);
