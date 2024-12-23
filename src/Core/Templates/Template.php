<?php

namespace App\Core\Templates;
use App\Core\Exceptions\TemplateException;
class Template
{
    /**
     * Class to render a page from an HTML template
     */
    private string $templateContent;
    public function __construct(
        string $titulo,
        string $estilo,
        string $conteudo
    )
    {
        $templateFile = __DIR__ . '/Template.html';
        // Check if the template file exists
        if (!file_exists($templateFile)) {
            throw new TemplateException("Template file '{$templateFile}' not found.");
        }
        // Read the file content
        $this->templateContent = file_get_contents($templateFile);
        if ($this->templateContent === false) {
            throw new TemplateException("Failed to read the template file '{$templateFile}'.");
        }
        $estilo .= <<<CSS
            header {
                background-image: url("/Core/Public/img/menu-bg-blue.svg");
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
            footer {
                background-image: url("/Core/Public/img/menu-bg-blue.svg");
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                transform: scale(-1, -1);
            }
            footer p {
                transform: scale(-1, -1);
            }
            CSS;
        // Replace placeholders
        $placeholders = ["{titulo}", "{estilo}", "{conteudo}"];
        $values = [$titulo, $estilo, $conteudo];
        $this->templateContent = str_replace($placeholders, $values, $this->templateContent);
        // Output the final content
        echo $this->templateContent;
    }
}
