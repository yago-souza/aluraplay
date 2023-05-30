<?php

namespace Yago\Aluraplay\Helper;

trait HtmlRendererTrait
{
    private function renderTemplate(string $templateName, array $context = []): string
    {
        $templatePath = __DIR__ . '/../../views/';
        extract($context);
        // Inicializa um buffer de saida
        ob_start();
        require_once $templatePath . $templateName . '.php';
        // me dá o conteúdo desse buffer
        return ob_get_clean();
        // pega o buffer de saida e já limpa o buffer
    }
}