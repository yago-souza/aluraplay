<?php

namespace Yago\Aluraplay\Controller;

abstract class ControllerWithHtml implements Controller
{
    private const TEMPLATE_PATH = __DIR__ . '/../../views/';
    protected function renderTemplate(string $templateName, array $context = []): string
    {
        extract($context);
        // Inicializa um buffer de saida
        ob_start();
        require_once self::TEMPLATE_PATH . $templateName . '.php';
        // me dá o conteúdo desse buffer
        return ob_get_clean();
        // pega o buffer de saida e já limpa o buffer
    }
}