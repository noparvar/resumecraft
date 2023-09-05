<?php

namespace ResumeCraft\Services\TemplateEngines;

interface TemplateEngineAdapter
{
    /**
     * @param array $data
     * @return string
     */
    public function renderTemplate(array $data): string;
}