<?php

namespace ResumeCraft\Services;

interface TemplateEngineAdapter
{
    /**
     * @param array $data
     * @return string
     */
    public function renderTemplate(array $data): string;
}