<?php

namespace ResumeCraft\Services;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class TemplateEngine
{

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
        return PROJECT_ROOT . '/resources/templates';
    }

    /**
     * @return array
     */
    public function getTemplateList() : array
    {
        return array_diff(scandir($this->getTemplatesPath()), array('.', '..'));
    }

    /**
     * @param array $resumeData
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function getHTML(array $resumeData): string
    {
        // Define an array of template names and their corresponding resume data keys
        $resumeDataKeys = array_values(
            str_replace('.twig', '', $this->getTemplateList())
        );

        $htmlContent = '';
        foreach ($resumeData as $dataKey => $dataValue) {
            if (in_array($dataKey, $resumeDataKeys)) {
                $htmlContent .= $this->twig()->render($dataKey . '.twig', [$dataKey => $dataValue]);
            }
        }

        return $htmlContent;
    }
}