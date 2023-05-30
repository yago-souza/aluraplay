<?php

namespace Yago\Aluraplay\Controller;

use Yago\Aluraplay\Helper\HtmlRendererTrait;

class LoginFormController implements Controller
{
    use HtmlRendererTrait;
    public function processaRequisicao(): void
    {
        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
            header('Location: /');
            return;
        }
        echo $this->renderTemplate('login-form');
    }
}