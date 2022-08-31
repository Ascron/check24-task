<?php declare(strict_types=1);

namespace Ascron\Check24Task\View;

class View
{
    public function render(string $template, array $data): string
    {
        $templatePath = $this->getTemplatePath($template);
        ob_start();
        extract($data);
        include_once $templatePath;
        return ob_get_clean();
    }

    private function getTemplatePath(string $template): string
    {
        return APP_DIR . '/templates/' . $template . '.php';
    }
}