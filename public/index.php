<?php

require_once '../vendor/autoload.php'; // Load Composer's autoloader

use ResumeCraft\ResumePDFGenerator;

$generator = new ResumePDFGenerator();
$dataFile = '../data.json';

$generator->generatePDF($dataFile);
