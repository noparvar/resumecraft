<?php

namespace ResumeCraft\Services\TemplateEngines;


class TemplateEngine
{
    private TemplateEngineAdapter $adapter;

    /**
     * @param TemplateEngineAdapter $adapter
     */
    public function __construct(TemplateEngineAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param array $resumeData
     * @return string
     */
    public function getHTML(array $resumeData): string
    {
        return $this->adapter->renderTemplate($resumeData);
    }
}