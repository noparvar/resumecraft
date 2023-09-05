<?php

namespace ResumeCraft;

use Mpdf\Tag\Th;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TemplateEngine
{
    const PROJECT_ROOT = __DIR__ . '/..'; // Define the constant for the root directory


    /**
     * @return Environment
     */
    public function twig(): Environment
    {
        $loader = new FilesystemLoader($this->getTemplatesPath());
        return new Environment($loader, [
            'cache' => false, // Set to '../cache/' if you want to use cache
        ]);
    }

    /**
     * @return string
     */
    private function getTemplatesPath(): string
    {
        return self::PROJECT_ROOT . '/resources/templates';
    }

    public function getTemplateList() : array
    {
        return array_diff(scandir($this->getTemplatesPath()), array('.', '..'));
    }
}